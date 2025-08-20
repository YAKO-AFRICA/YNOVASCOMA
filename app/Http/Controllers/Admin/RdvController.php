<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tblrdv;
use App\Models\TblVille;
use App\Models\TblVilleReseau;
use App\Models\TblTypePrestation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RdvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('rdv.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $typePrestation = TblTypePrestation::where('id', $id)->first();
        $villes = TblVille::all();
        $villeReseaux = TblVilleReseau::select('idVilleBureau', 'libelleVilleBureau')
        ->whereHas('optionRdv') // Vérifie que la relation 'optionRdv' existe
        ->with('optionRdv') // Charge les options de rendez-vous pour chaque ville réseau
        ->get();
        $contract = session('contractDetails', []);
        $contractDetails = $contract['details'][0] ?? [];
        $membreDetails   = $contract['membre'] ?? [];
        // dd($contractDetails);
        // $membreDetails = session('membreDetails', []);

        // dd($contractDetails, $membreDetails);
        if (empty($contract)) {
            return redirect()->back()->withErrors('Les détails du contrat sont introuvables.');
        }
        return view('rdv.create', compact('typePrestation', 'villes', 'villeReseaux', 'contractDetails', 'membreDetails'));
    }
    public function getOptionRdv(string $id)
    {
        $villeReseaux = TblVilleReseau::where('idVilleBureau', $id)
        ->whereHas('optionRdv') // Vérifie que la relation 'optionRdv' existe
        ->with('optionRdv') // Charge les options de rendez-vous pour chaque ville réseau
        ->get();
        return response()->json([
            'status' => 'success',
            'data' => $villeReseaux
        ]);
    }
    public function getRdvByDate(Request $request)
{
    try {
        // Valider les paramètres d'entrée
        $validated = $request->validate([
            'idTblBureau' => 'required|integer',
            // 'idTblBureau' => 'required|integer|exists:tblvillebureau,idVilleBureau',
            'daterdv' => 'required',
        ]);

        // Reformater la date pour correspondre au format de la base (d-m-Y)
        // $daterdv = DateTime::createFromFormat('d/m/Y', $validated['daterdv'])->format('d-m-Y');

        // Requête pour récupérer le rendez-vous
        $rdv = Tblrdv::where('idTblBureau', $validated['idTblBureau'])
            ->where('daterdv', $validated['daterdv']) // Comparaison avec le champ VARCHAR
            ->first();

        if ($rdv) {
            return response()->json([
                'status' => 'success',
                'data' => $rdv
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Aucun rendez-vous trouvé pour cette date et ce lieu.'
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Erreur : ' . $e->getMessage()
        ], 500);
    }
}




    // public function getOptionRdv($id, $dateRdv)
    // {
    //     $villeReseaux = TblVilleReseau::where('idVilleBureau', $id)
    //         ->whereHas('rdv', function ($query) use ($dateRdv) {
    //             $query->where('daterdv', $dateRdv); // Filtrer les rdv par date
    //         })
    //         ->with(['rdv' => function ($query) use ($dateRdv) {
    //             $query->where('daterdv', $dateRdv); // Charger uniquement les rdv de la date
    //         }, 'optionRdv']) // Charger également les options de rendez-vous
    //         ->get();
    //         // dd($villeReseaux);
    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $villeReseaux
    //     ]);
    // }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $coderdv = RefgenerateCode(Tblrdv::class, 'RDV-', 'codedmd');
    
            // Création de la prestation
            $rdv = Tblrdv::create([
                'nomclient'=>$request->nomclient,
                'tel'=>$request->tel,
                'email'=>$request->email,
                'daterdv'=>$request->daterdv,
                'codedmd' => $coderdv,
                'dateajou' => Carbon::now()->format('d/m/Y à H:i:s'),
                'etat' =>1,
                'motifrdv'=>$request->motifrdv,
                'police'=>$request->police,
                'titre'=>$request->titre,
                'datenaissance'=>$request->datenaissance,
                'lieuresidence'=>$request->lieuresidence,
                'idTblBureau'=>$request->idTblBureau,
                'createdAt' => Carbon::now()->format('d/m/Y H:i:s'),
                'creeLe' => Carbon::now(),
                'orderInsert' =>1,
            ])->save();
            
            if ($rdv) {
                $dataResponse =[
                    'type'=>'success',
                    'urlback'=>"back",
                    'message'=>"RDV N° $coderdv enregistré avec succes!",
                    'code'=>200,
                ];
                DB::commit();
           } else {
                DB::rollback();
                $dataResponse =[
                    'type'=>'error',
                    'urlback'=>'',
                    'message'=>"Erreur lors de l'enregistrement!",
                    'code'=>500,
                ];
           }
    
        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse =[
                'type'=>'error',
                'urlback'=>'',
                'message'=>"Erreur systeme! $th",
                'code'=>500,
            ];
        }
            return response()->json($dataResponse);
    }

}
