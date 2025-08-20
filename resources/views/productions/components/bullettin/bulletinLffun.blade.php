<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulaire de souscription</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <style>
        input {
            font-size: 20px;
            color: #000;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-size: 12px;
        }

        body {
            font-family: Arial, sans-serif;
            padding-left: 35px;
            padding-right: 35px;
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .chechbox {
            border: 1px solid black;
            color: #fff;
            max-width: 3px !important;
            max-height: 3px !important;
            font-size: 9px;
            margin-right: 5px;
        }
        .underline {
            text-decoration: underline;
        }
    </style>

    <div class="a4-container ">
        <center>
            <img src="https://ascoma.yakoafricassur.com/logos/casudco.jpg" alt="Logo" style="max-height: 30px;width: 120px">
        </center>
        <section>
            <div class="container1_1 row" style="width: 100%; align-items: center">
        
                <div style="width: 25%; float: left; justify-content: start">
                    <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('root/images/logo.png'))) }}" alt="Logo" style="width: 100px">
                </div>
                
                <div style="width: 50%; float: center; margin-left: 170px; border: 1px solid black; padding: 5px">
                    <div>
                        <center>
                            <h2>BULLETIN DE SOUSCRIPTION</h2>
                        </center>
                    </div>
                </div>
                <div style="width: 25%; float: right; margin-top: -20px; margin-right: -50px">
                    <img src="https://ascoma.yakoafricassur.com/logos/ASCOMA.png" alt="Logo" style="width: 130px">
                </div>
            </div>
        </section>
        
        
        <section style="margin-top: 50px">
            <div class="container1_1 row underline" style="width: 100%; align-items: center;">
                <h3>CONDITIONS PARTICULIERES CONVENTION N° 000-00</h3>
            </div>
        </section>

        <div style="width: 100%;">
            <div class="col" style="width: 50%; float: left">Agence : {{ $contrat->agence ?? '.................' }}</div>
            <div class="col" style="width: 50%; float: right; text-align: right; margin-right: 0px">Bulletin N° : {{ $contrat->id ?? '' }}</div>
        </div>

        <section>
            <fieldset class="" style="border: 1px solid #ccc; margin-top: 30px; min-height: 120px">
                <legend class="float-none w-auto" style="float: none; width: auto; border: 1px solid #ccc;">
                    <small style="padding: 2px">INFORMATIONS ADHERENT</small>
                </legend>
    
                <div class="content1" style="padding: 5px; margin-top: 5px">
                    <div class="identite" style="width: 100%">
                        <div class="civilite" style="float: left; width: 50%">
                            <label for="civilite"><strong>Genre :</strong> {{ $contrat->adherent->civilite ?? '' }}</label>
                        </div>
    
                        <div class="telephone" style="float: right; width: 50%">
                            <div class="telephone">
                                <label for="telephone"><strong>Situation Matrimoniale : </strong> 
                                    {{ getSituationMatrimonialeLabel($contrat->adherent->situationMatrimoniale)}}
                                </label>
                            </div>
                        </div>
                    </div>

                    <p class="identite" style="margin-top: 10px;">
                        <div class="nom" style="float: left; width: 50%;">
                            <label for="nom"><strong>Nom :</strong> {{ $contrat->adherent->nom ?? ''}}</label>
                        </div>
                        <div class="prenom" style="float: right; width: 50%;">
                            <label for="prenom"><strong>Prenom :</strong> {{ $contrat->adherent->prenom ?? ''}}</label>
                        </div>
                    </p>
                    

                    <p class="identite" style="margin-top: 5px;">
                        <div class="bithday" style="float: left; width: 50%;">
                            <label for="bithday"><strong>Date de naissance :</strong>{{ $contrat->adherent->datenaissance ?? ''}}</label>
                        </div>

                        <div class="lieunaissance" style="float: right; width: 50%;">
                            <label for="lieunaissance"><strong>lieu de naissance :</strong> {{ $contrat->adherent->lieunaissance ?? ''}}</label>
                        </div>
                    </p>

                    <p class="identite" style="margin-top: 5px">
                        <div class="domicile" style="float: left ;width: 50%">
                            <label for="domicile"><strong>Domicile :</strong>  {{ $contrat->adherent->lieuresidence ?? '' }}</label>
                        </div>
                        <div class="postal" style="float: right; width: 50%">
                            <div class="postal">
                                <label for="postal"><strong>Email :</strong>  {{ $contrat->adherent->email ?? '' }}</label>
                            </div>
                        </div>
                    </p>
                    <p class="identite" style="margin-top: 5px">
                        <div class="profession" style="float: left ;width: 50%">
                            <label for="profession"><strong>Profession :</strong>  {{ $contrat->adherent->profession ?? '' }}</label>
                        </div>
                        <div class="employeur" style="float: right; width: 50%">
                            <div class="employeur">
                                <label for="employeur"><strong>Employeur :</strong> <span>{{ $contrat->adherent->employeur ?? '' }}</span></label>
                            </div>
                        </div>
                    </p>
                    <p class="identite" style="margin-top: 5px">
                        <div class="numeropiece" style="float: left ;width: 50%">
                            <label for="numeropiece"><strong>CNI/Passport/Attestation d'identité :</strong> {{ $contrat->adherent->numeropiece ?? '' }}</label>
                        </div>
                        <div class="telephone" style="float: right; width: 50%">
                            <div class="telephone">
                                <label for="telephone"><strong>Téléphone / Cell :</strong> <span>{{ $contrat->adherent->telephone ?: $contrat->adherent->mobile }}</span></label>
                            </div>
                        </div>
                    </p>
                </div>
            </fieldset>
        </section>

        <style>

            table {
                border-collapse: collapse;
                width: 100%;
                font-size: 10px;
            }

            th, td {
                border: 1px solid #999;
                padding: 2px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
        </style>

        <section>
            <fieldset class="" style="border: 1px solid #ccc; margin-top: 15px">
                <legend class="float-none w-auto" style="float: none; width: auto; border: 1px solid #ccc;">
                    <small style=" padding: 2px">INFORMATIONS DES L'ASSURES</small>
                </legend>

                <table style="margin-top: 25px; font-size: 8px">
                    <thead style="font-size: 8px">
                        <tr>
                            <th>Nom Complet</th>
                            <th>Date Naissance</th>
                            <th>Domicile</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Garantie</th>
                            <th>Capital</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 8px">
                        @php $count = 0; @endphp

                        @foreach ($contrat->assures as $assure)
                            <tr>
                                <td style="font-size: 8px">{{ $assure->nom ?? '' }} {{ $assure->prenom ?? '' }}</td>
                                <td style="font-size: 8px">{{ $assure->datenaissance ?? ''}}</td>
                                <td style="font-size: 8px">{{ $assure->lieuresidence ?? '' }}</td>
                                <td style="font-size: 8px">{{ $assure->email ?? '' }}</td>
                                <td style="font-size: 8px">{{ $assure->telephone ?? '' }}</td>

                                @php
                                    $garanties = $assure->garanties ?? collect();
                                    $gar1 = $garanties->get(0);
                                    $gar2 = $garanties->get(1);
                                @endphp

                                <td style="font-size: 8px">{{ $gar1->monlibelle ?? '' }}</td>
                                <td>{{ $gar1->capitalgarantie ?? '' }}</td>
                            </tr>
                            @php $count++; @endphp
                        @endforeach

                        @for ($i = $count; $i < 8; $i++)
                            <tr>
                                <td>.........................</td>
                                <td>.........................</td>
                                <td>.........................</td>
                                <td>.........................</td>
                                <td>.........................</td>
                                <td style="font-size: 8px">.........................</td>
                                <td>.........................</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </fieldset>
        </section>



        <fieldset class="" style="border: 1px solid #ccc; padding: 1rem; margin-top: 20px">
            <legend class="float-none w-auto px-2" style="float: none; width: auto; font-size: 0.875rem; border: 1px solid #ccc; padding: 5px">
                <small style="">GARANTIES SOUSCRITES ET PRIMES D'ASSURANCE</small>
            </legend>

            <div class="prime " style="margin-top: 10px">
                <div>
                    <strong class="underline">
                        Prime d'assurance : {{ number_format($contrat->primepricipale, 2, ',', ' ') }} F CFA
                    </strong>
                </div>
                <div style="margin-left: 300px; margin-top: -28px">
                    ({{ nombreEnLettre($contrat->primepricipale) }} Franc cfa)
                </div>
                
            </div>
            <div class="prime " style="margin-top: 10px">
                <div>
                    <strong class="underlin">
                       Fraies d'adhesion : <span >{{ $contrat->fraisadhesion ?? '' }}</span>
                    </strong>
                </div>
                <div style="margin-left: 300px; margin-top: -28px">
                    Option de garanties : <span style="margin-left: 40px"><span>{{ $contrat->Formule ?? '' }}</span></span>
                </div>
                
            </div>

            <div style="margin-top: 15px">
                Cette prime sera prélévée 
                @if ($contrat->periodicite == 'A')
                    Annuellement
                @else
                    Mensuellement
                @endif sur le compte d'épargne du client à raison de  
                <span class="underline">{{ number_format($contrat->primepricipale, 2, ',', ' ') }} FCFA par @if ($contrat->periodicite == 'A') année @else Mois @endif</span>
            </div>

        </fieldset>


        <fieldset class="" style="border: 1px solid #ccc; padding: 1rem; margin-top: 30px">
            <legend class="float-none w-auto px-2" style="float: none; width: auto; font-size: 0.875rem; border: 1px solid #ccc; padding: 5px">
                <small style="">INFORMATIONS GENERALES DU CLIENT</small>
            </legend>
        
            <div style="margin-top: 20px">
                Après avoir pris connaissance  du résumé des conditions générale de <strong>YAKO FRAIS FUNERAIRES</strong> au verso de la présente, <br>
                je déclare adherer à ce contrat suivant les caractéristiques indiquées ci-dessus. <br>
                Je déclare avoir reçu un exemplaire du présent document résumant les conditions générales du contrat YAKO FRAIS FUNERAIRES.
            </div>
        </fieldset>

        <section>
            <div class="fait" style="width: 100%; margin-top: 10px">

                <label for="fait">Fait à : ......................................................................le...........................................................................</label>

            </div>
        </section>

        <section style="margin-top: 30px">
            <div class="identiteee row" style="width: 100%">
                <div class="col-4" style="width: 30%; float: left;  justify-content: center">

                    <div class="nom">
                        <label for="nom"><strong class="underline">L'ADHERENT </strong></label> <br>
                        <span>(signature précedée de la mention <br>
                        "Lu et Approuvé")</span>
                    </div>

                    <div>
                         @if ($imageSrc != null)
                            <img src="{{ $imageSrc }}" alt="QR Code de vérification" style="width: 55px; height: 55px;">
                        @endif
                    </div>

                </div>

                <div class="col-4"  style="margin-left: 280px;float: center;">

                    <div class="nom">

                        <label for="nom"><strong class="underline">POUR CASUDCO </strong></label>

                        <div>
                            <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('root/images/sign_casudco.jpg'))) }}" alt="Logo" style="width: 180px">
                        </div>
                    </div>

                </div>
                <div class="col-4"  style="width: 30%; float: right;">

                    <div class="sign-yako">

                        <strong class="underline">POUR L'ASSUREUR</strong>
                        <div>
                            <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('root/images/Signature_Dta.jpg'))) }}" alt="Logo" style="width: 200px">
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>



</html>

