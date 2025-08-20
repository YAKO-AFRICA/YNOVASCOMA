<?php

namespace App\Http\Controllers\Admin;


use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\Contrat;


use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use setasign\Fpdi\PdfReader\StreamReader;

class BulletinController extends Controller
{

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ini_set('memory_limit', '1024M');

        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contrat = Contrat::find($id);
        return view('productions.components.bullettin.basicBulletin', compact('contrat'));
    }






    public function generateBulletinEtCGU()
    {
        try {
            // Options DomPDF
            $options = new Options();
            $options->set('isRemoteEnabled', true);

            // Générer le PDF bulletin en mémoire
            $pdf = PDF::loadView('productions.components.bullettin.bulletinLibre')
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                ]);

            $bulletinContent = $pdf->output(); // Contenu binaire du PDF

            // --- Écriture dans un fichier temporaire système ---
            $tempFile = tempnam(sys_get_temp_dir(), 'bulletin_'); 
            file_put_contents($tempFile, $bulletinContent);

            // Fichier CGU
            $cguFile = public_path('root/cgu/CGsoutienFidel.pdf');

            // Fusion avec FPDI
            $fpdi = new Fpdi();

            // Charger bulletin
            $fpdi->AddPage();
            $fpdi->setSourceFile($tempFile);
            $tplIdx = $fpdi->importPage(1);
            $fpdi->useTemplate($tplIdx);

            // Ajouter pages CGU
            $pageCount = $fpdi->setSourceFile($cguFile);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $fpdi->AddPage();
                $tplIdx = $fpdi->importPage($pageNo);
                $fpdi->useTemplate($tplIdx);
            }

            // Supprimer le fichier temporaire immédiatement
            unlink($tempFile);

            // Sortie finale en mémoire
            $finalPdfContent = $fpdi->Output('S'); // 'S' = retourne le contenu au lieu de sauvegarder

            // Retourner directement au navigateur
            return response($finalPdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Bulletin_Blank.pdf"',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'Erreur lors de la génération du PDF : ' . $th->getMessage(),
                'code' => 500,
            ]);
        }
    }


    public function generate(request $request, $id)
    {
        DB::beginTransaction();
        try {
            $contrat = Contrat::find($id);
            if($contrat)
            {
                // Options pour Dompdf
                $options = new Options();
                $options->set('isRemoteEnabled', true);
            
                // Générer le bulletin PDF avec Dompdf
                if ($contrat->codeproduit === "LPREVO") {
                    $pdf = PDF::loadView('productions.components.bullettin.LPREVOBulletin', [
                        'contrat' => $contrat,
                    ])
                    ->setPaper('a4', 'portrait')
                    ->setOptions([
                        'isHtml5ParserEnabled' => true,
                        'isRemoteEnabled' => true,
                    ]);
                }else{
                    $pdf = PDF::loadView('productions.components.bullettin.securCompt', [
                        'contrat' => $contrat,
                    ])
                    ->setPaper('a4', 'portrait')
                    ->setOptions([
                        'isHtml5ParserEnabled' => true,
                        'isRemoteEnabled' => true,
                    ]);
                }
            
                // Répertoire pour enregistrer les fichiers temporaires
                $bulletinDir = public_path('documents/bulletin/');
                if (!is_dir($bulletinDir)) {
                    mkdir($bulletinDir, 0777, true);
                }
            
                $bulletinFileName = $bulletinDir . 'temp_bulletin_' . $contrat->id . '.pdf';
                $pdf->save($bulletinFileName);
            
                // Chemin vers le fichier CGU
                // $cguFile = public_path('root/cgu/CGPLanggnant.pdf');
                $cguFile = public_path('root/cgu/CguCMF.pdf');
            
                // Fusionner les PDF avec FPDI
                $finalPdf = new Fpdi();
            
                // Ajouter les pages du bulletin
                $finalPdf->AddPage();
                $finalPdf->setSourceFile($bulletinFileName);
                $tplIdx = $finalPdf->importPage(1);
                $finalPdf->useTemplate($tplIdx);
            
                // Ajouter toutes les pages du fichier CGU
                $pageCount = $finalPdf->setSourceFile($cguFile);
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $finalPdf->AddPage();
                    $tplIdx = $finalPdf->importPage($pageNo);
                    $finalPdf->useTemplate($tplIdx);
                }
            
                // Nom final du fichier
                $finalFileName = $bulletinDir . 'basic_bulletin_' . $contrat->id . '.pdf';
            
                // Enregistrer le PDF final
                $finalPdf->Output($finalFileName, 'F');
            
                // Supprimer le fichier temporaire du bulletin
                unlink($bulletinFileName);

                DB::commit();
            
                // Retourner le PDF final en tant que réponse
                return response()->file($finalFileName, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . basename($finalFileName) . '"'
                ]);

                
            }else{
                DB::rollBack();
                return response()->json([
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Erreur lors de la generation du bullettin! $th",
                    'code' => 500,
                ]);
            }
            
    
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'type' => 'error',
                'urlback' => '',
                'message' => "Erreur système! $th",
                'code' => 500,
            ]);
        }

    }

    public function generateBulletinSecuriCompt($id)
    {
        ini_set('memory_limit', '1024M');

        $racine = "8301100011116";

        // Trouver le dernier bulletin pour incrémenter
        $dernierBulletin = Contrat::where('codeproduit', "SECURICPTE")->orderBy('numBullettin', 'desc')->first();
        $numGenerer = $dernierBulletin ? ((int)substr($dernierBulletin->numBullettin, strlen($racine))) + 1 : 1;

        // Construire le numéro de bulletin unique
        $numeroBulletin = $racine . $numGenerer;

        // dd($numeroBulletin);

        try {
            // Récupérer les données nécessaires au bulletin
            $contrat = Contrat::findOrFail($id);

            // Options pour DomPDF
            $options = new Options();
            $options->set('isRemoteEnabled', true);


            $imageUrl = env('SIGN_API') . "api/get-signature/" . $id . "/E-SOUSCRIPTION";
            $imageSrc = null;
            try {
                $response = Http::timeout(5)->get($imageUrl);

                if ($response->successful()) {
                    $data = $response->json();

                    // Vérifie si 'error' existe et est à true
                    if (isset($data['error']) && $data['error'] === true) {
                        Log::info('Signature non trouvée pour le contrat ID: ' . $contrat->id);
                    } else {
                        $imageData = $response->body(); 
                        $base64Image = base64_encode($imageData);
                        $imageSrc = 'data:image/png;base64,' . $base64Image;
                    }
                } else {
                    Log::error('Erreur HTTP lors de l\'appel de l\'API signature. Code de retour : ' , $response->json());
                }
            } catch (\Exception $e) {
                Log::error('Exception lors de la récupération de la signature : ' . $e->getMessage());
            }

            $pdf = PDF::loadView('productions.components.bullettin.bulletinLffun', [
                'contrat' => $contrat,
                'imageSrc' => $imageSrc
            ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

            $bulletinDir = public_path('documents/bulletin/');
            if (!is_dir($bulletinDir)) {
                mkdir($bulletinDir, 0777, true);
            }

            $tempBulletinPath = $bulletinDir . 'temp_bulletin_' . $contrat->id . '.pdf';
            $pdf->save($tempBulletinPath);

            // Chemin vers le fichier CGU
            // $cguFilePath = public_path('root/cgu/CGPLanggnant.pdf');
            $cguFilePath = public_path('root/cgu/CGsoutienFidel.pdf');

            // Initialiser FPDI pour fusionner les fichiers
            $finalPdf = new Fpdi();

            // Ajouter le bulletin au PDF final
            $finalPdf->AddPage();
            $finalPdf->setSourceFile($tempBulletinPath);
            $bulletinTplIdx = $finalPdf->importPage(1);
            $finalPdf->useTemplate($bulletinTplIdx);

            // Ajouter les pages du fichier CGU
            $cguPageCount = $finalPdf->setSourceFile($cguFilePath);
            for ($pageNo = 1; $pageNo <= $cguPageCount; $pageNo++) {
                $finalPdf->AddPage();
                $cguTplIdx = $finalPdf->importPage($pageNo);
                $finalPdf->useTemplate($cguTplIdx);
            }

            // Nom final du fichier fusionné
            $finalBulletinPath = $bulletinDir . 'bulletinLffun' . $contrat->id . '.pdf';
            $finalPdf->Output($finalBulletinPath, 'F');

            // Supprimer le fichier temporaire du bulletin
            unlink($tempBulletinPath);

            // Définir l'URL publique pour le fichier final
            $fileUrl = asset("documents/bulletin/bulletinLffun{$contrat->id}.pdf");

            return response()->file($finalBulletinPath, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . basename($finalBulletinPath) . '"'
                ]);

        } catch (\Exception $e) {
            Log::error("Erreur lors de la génération du bulletin : ", ['error' => $e]);
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

 


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
