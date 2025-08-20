<div id="test-l-5" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger6">
    <h5 class="mb-1">Résumé des informations</h5>
    <p class="mb-4">Veuillez relire vos informations pour verifier si elles sont correctes</p>

    <div class="row g-3">
        <div class="col-12">
            <div class="card" style="width: 100%">
                <div class="card-header">
                    <h4>Adhérent</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6  col-xs-12 border-r">
                            <dl class="row">
                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Civilité:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayCivility">-- </dd>

                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Nom:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayNom">--</dd>

                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Prénoms:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayPrenom">--</dd>

                                {{-- <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >Sexe:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displaySexe">Null</dd> --}}

                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Date de naissance:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayBirthday">--</dd>
                                

                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Lieu de naissance:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayLieuNaissance">--</dd>

                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Lieu de résidence:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayResidence">--</dd>

                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">N° pièce</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayNumPiece">--</dd>
                            </dl>
                        </div>
                        <div class="col-6 col-xs-12">
                            <dl class="row">
                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Profession:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayProfession">--</dd>
                        
                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Secteur d'activité:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayEmployeur">--</dd>
                        
                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Email:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayEmail">--</dd>
                        
                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Téléphone:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayTelephone">--</dd>
                        
                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Mobile:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayMobile">--</dd>
                        
                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Mobile 2:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayMobile1">--</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card" style="width: 100%">
                <div class="card-header">
                    <h4>Conditions de paiement de la prime & périodicité</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6  col-xs-12 border-r">
                            <dl class="row">
                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Produit:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6">{{ $product->MonLibelle ?? "null"}}</dd>

                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Date Effet:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayDateEffet">-</dd>

                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Prime principale:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayPrimepricipale">---</dd>

                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Frais d'adhésion:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayFraisAdhesion">2500</dd>

                                {{-- <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Echéance paiement:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Lorem, ipsum dolor.</dd> --}}
                                
                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Capital souscripteur désiré:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayCapital">1000000</dd>
                            </dl>
                        </div>
                        <div class="col-6  col-xs-12">
                            <dl class="row">
                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Mode paiement:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayModePaiement">Virement bancaire</dd>

                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Duree:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayDureePay">12</dd>

                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Organisme payeur:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayOrganisme">CASUDCO</dd>

                                <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Agence:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayAgence">-</dd>

                                {{-- <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">N° Compte:</dt>
                                <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayNumeroCompte">-</dd> --}}
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card" style="width: 100%">
                <div class="card-header">
                    <h4>Assuré(e)s</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 overflow-auto overflow-scroll">
                            <table class="table mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prénoms</th>
                                        <th scope="col">Né(e) le</th>
                                        <th scope="col">Lieu de naissance</th>
                                        <th scope="col">Lieu de résidence</th>
                                        <th scope="col">Filiation</th>
                                        <th scope="col">Garanties</th>
                                        <th scope="col">Téléphone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">N° pièce</th>
                                    </tr>
                                </thead>
                                <tbody id="resumAssur">
                                    
                                </tbody>
                                <tfoot>
                                    <tr id="resume-row">
                                        <td id="display-nom">-</td>
                                        <td id="display-prenom">-</td>
                                        <td id="display-date-naissance">-</td>
                                        <td id="display-lieu-naissance">-</td>
                                        <td id="display-lieu-residence">-</td>
                                        <td id="display-filiation">Moi-même</td>
                                        <td id="display-garanties">
                                            <ul>
                                                @foreach ($productGarantie->where('CodeProduitGarantie', "ASSFUN_ADH") as $item)
                                                    <li>{{ $item->MonLibelle }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td id="display-telephone">-</td>
                                        <td id="display-email">-</td>
                                        <td id="display-numeropiece">-</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card" style="width: 100%">
                <div class="card-header">
                    <h4>Bénéficiaire(s)</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="card col-lg-6 col-md-6 col-sm-12">
                            <div class="card-header">
                                <p>En cas de décès avant le terme</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-lg-7 col-md-6 col-sm-6 border-r" id="display-beneficiaire-terme">

                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- <div class="card col-lg-6 col-md-6 col-sm-12">
                            <div class="card-header">
                                <p>En cas de décès avant le terme</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-lg-7 col-md-6 col-sm-6 border-r" id="display-beneficiaire-deces">

                                    </div>
                                </div>
                            </div>

                        </div> --}}
                    </div>
                </div>

                <div class="col-12">
            <div class="card" style="width: 100%">
                <div class="card-header">
                    <h4>Beneficiaires</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 overflow-auto overflow-scroll">
                            <table class="table mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prénoms</th>
                                        <th scope="col">Né(e) le</th>
                                        <th scope="col">Lieu de naissance</th>
                                        <th scope="col">Lieu de résidence</th>
                                        <th scope="col">Filiation</th>
                                        <th scope="col">Téléphone</th>
                                        <th scope="col">Email</th>
                                    </tr>
                                </thead>
                                <tbody id="beneficiairesTableBody">
                                </tbody>

                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>


        <div class="col-12">
            <div class="col-12 d-flex justify-content-between">
                <button class="btn border-btn px-4 btn-previous-form" onclick="event.preventDefault(); stepper1.previous()">
                    <i class='bx bx-left-arrow-alt me-2'></i>Retour
                </button>
                <button id="btn-next" class="btn btn-two px-4 btn-next-for btn-auto-generate" type="button" onclick="stepper1.next()">
                    Enregistrer<i class='bx bx-right-arrow-alt ms-2'></i>
                </button>
            </div>
        </div>
    </div>
    <!---end row-->


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const isAssureOui = document.querySelector('input[name="estAssure"]:checked'); 
            const fields = {
                nom: document.getElementById('FisrtName'),
                prenom: document.getElementById('LastName'),
                dateNaissance: document.getElementById('Date_naissance'),
                lieuNaissance: document.getElementById('lieunaissance'),
                lieuResidence: document.getElementById('lieuresidence'),
                telephone: document.querySelector('[name="mobile"]'),
                email: document.getElementById('email'),
                numeroPiece: document.getElementById('numeropiece'),
                modepaiement: document.querySelector('input[name="modepaiement"]:checked'),
                matricule: document.querySelector('input[name="numerocompte"]'),
            };
    
            const displayFields = {
                nom: document.getElementById('display-nom'),
                prenom: document.getElementById('display-prenom'),
                dateNaissance: document.getElementById('display-date-naissance'),
                lieuNaissance: document.getElementById('display-lieu-naissance'),
                lieuResidence: document.getElementById('display-lieu-residence'),
                telephone: document.getElementById('display-telephone'),
                email: document.getElementById('display-email'),
                numeroPiece: document.getElementById('display-numeropiece'),
                nomSouscripteur: document.getElementById('displayNom'),
                prenomSouscripteur: document.getElementById('displayPrenom'),
                dateNaissanceSouscripteur: document.getElementById('displayBirthday'),
                mobileSouscripteur: document.getElementById('displayMobile'),
                emailSouscripteur: document.getElementById('displayEmail'),
                numeroPieceSouscripteur: document.getElementById('displayNumPiece'),
                modepaiement: document.getElementById('displayModePaiement'),
                matricule: document.getElementById('displayNumeroCompte'),
            };

            
            // Function to update the table
            function updateTable() {
                if (isAssureOui.checked) {
                    displayFields.nom.textContent = fields.nom.value;
                    displayFields.prenom.textContent = fields.prenom.value;
                    displayFields.dateNaissance.textContent = fields.dateNaissance.value;
                    displayFields.lieuNaissance.textContent = fields.lieuNaissance.value;
                    displayFields.lieuResidence.textContent = fields.lieuResidence.value;
                    displayFields.telephone.textContent = fields.telephone.value;
                    displayFields.email.textContent = fields.email.value;
                    displayFields.numeroPiece.textContent = fields.numeroPiece.value;
                    displayFields.nomSouscripteur.textContent = fields.nom.value;
                    displayFields.prenomSouscripteur.textContent = fields.prenom.value;
                    displayFields.dateNaissanceSouscripteur.textContent = fields.dateNaissance.value;
                    displayFields.mobileSouscripteur.textContent = fields.telephone.value;
                    displayFields.emailSouscripteur.textContent = fields.email.value;
                    displayFields.numeroPieceSouscripteur.textContent = fields.numeroPiece.value;
                    displayFields.modepaiement.textContent = fields.modepaiement.value;
                    displayFields.matricule.textContent = fields.matricule.value;
                }
            }
    
            // Listen for changes on input fields
            Object.values(fields).forEach(field => {
                field.addEventListener("input", updateTable);
            });
    
            // Listen for changes on "Oui" radio button
            isAssureOui.addEventListener("change", updateTable);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // Récupération des bénéficiaires depuis sessionStorage
            const storedBeneficiaries = JSON.parse(sessionStorage.getItem("beneficiariesData")) || [];

            console.log("Beneficiaires :", storedBeneficiaries);

            // Cible le tbody du tableau
            const tableBody = document.getElementById("beneficiairesTableBody");

            // Vide le contenu actuel
            tableBody.innerHTML = "";

            console.log("Beneficiaires :", storedBeneficiaries);

            // Génère les lignes HTML pour chaque bénéficiaire
            storedBeneficiaries.map(beneficiary => {
                const row = `
                    <tr>
                        <td>${beneficiary.nom}</td>
                        <td>${beneficiary.prenom}</td>
                        <td>${beneficiary.dateNaissance}</td>
                        <td>${beneficiary.lieuNaissance}</td>
                        <td>${beneficiary.lieuResidence}</td>
                        <td>${beneficiary.lienParente}</td>
                        <td>${beneficiary.telephone}</td>
                        <td>${beneficiary.email}</td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        });

    </script>


    
</div>

<script>
    // Fonction pour afficher le résumé des assurés
    function afficherResumeAssures() {
        const tbodyResume = document.getElementById('resumAssur');
        if (!tbodyResume) return;

        tbodyResume.innerHTML = '';

        console.log("Assures :", assures);

        assures.forEach(assure => {
            if (!assure) return;

            const row = document.createElement('tr');
            
            // Colonne Nom
            const tdNom = document.createElement('td');
            tdNom.textContent = assure.nom || '';
            row.appendChild(tdNom);
            
            
            // Colonne Prénoms
            const tdPrenom = document.createElement('td');
            tdPrenom.textContent = assure.prenom || '';
            row.appendChild(tdPrenom);
            
            // Colonne Date de naissance
            const tdDateNaissance = document.createElement('td');
            tdDateNaissance.textContent = assure.datenaissance || '';
            row.appendChild(tdDateNaissance);
            
            // Colonne Lieu de naissance
            const tdLieuNaissance = document.createElement('td');
            tdLieuNaissance.textContent = assure.lieuNaissance || '';
            row.appendChild(tdLieuNaissance);
            
            // Colonne Lieu de résidence
            const tdLieuResidence = document.createElement('td');
            tdLieuResidence.textContent = assure.lieuresidenceAssur || '';
            row.appendChild(tdLieuResidence);
            
            // Colonne Filiation
            const tdFiliation = document.createElement('td');
            tdFiliation.textContent = assure.filiation || '';
            row.appendChild(tdFiliation);

            // Colonne Capital
            const tdCapital = document.createElement('td');
            tdCapital.textContent = assure.capital || '';
            row.appendChild(tdCapital);
            
            // Colonne Garanties
            const tdGaranties = document.createElement('td');
            const ulGaranties = document.createElement('ul');
            
            const garanties = Array.isArray(assure.garanties) ? assure.garanties : [];
            garanties.forEach(garantie => {
                if (garantie?.MonLibelle) {
                    const li = document.createElement('li');
                    li.textContent = garantie.MonLibelle;
                    ulGaranties.appendChild(li);
                }
            });
            
            if (garanties.length === 0) {
                const li = document.createElement('li');
                li.textContent = 'Pas de garantie';
                ulGaranties.appendChild(li);
            }
            
            tdGaranties.appendChild(ulGaranties);
            row.appendChild(tdGaranties);
            
            // Colonne Téléphone
            const tdTelephone = document.createElement('td');
            tdTelephone.textContent = assure.mobileAssur || '';
            row.appendChild(tdTelephone);
            
            // Colonne Email
            const tdEmail = document.createElement('td');
            tdEmail.textContent = assure.emailAssur || '';
            row.appendChild(tdEmail);
            
            // Colonne N° pièce
            const tdNumeroPiece = document.createElement('td');
            tdNumeroPiece.textContent = assure.naturepieceAssur || '';
            row.appendChild(tdNumeroPiece);
            
            tbodyResume.appendChild(row);
            afficherResumeAssures();
        });
    }

</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {


        const termeContrat = document.querySelector('input[name="addBeneficiary"]:checked');
        const resumeTermeContrat = document.getElementById('display-beneficiaire-terme');

        if (termeContrat) {
            const valeurterme = termeContrat.value;
            console.log(valeurterme);
            
            resumeTermeContrat.textContent = valeurterme;
        }

        const audecesContrat = document.querySelector('input[name="audecesContrat"]:checked');
        const resumeAudecesContrat = document.getElementById('display-beneficiaire-deces');

        if (audecesContrat) {
            const valeur = audecesContrat.value;

            resumeAudecesContrat.textContent = valeur;
        }

        
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Sélection des éléments
    const displayBenefTerme = document.getElementById('display-beneficiaire-terme');
    const displayBenefDeces = document.getElementById('display-beneficiaire-deces');

    // Liste des options de sélection
    const options = [
        { checkboxId: 'addBeneficiary', label: 'Adhérent', target: displayBenefTerme },
        { checkboxId: 'conjoint1', label: 'Le conjoint non divorcé, ni séparé de corps', target: displayBenefTerme },
        { checkboxId: 'enfants', label: 'Les enfants nés et à naître', target: displayBenefTerme },
        { checkboxId: 'Autres1', label: 'Autres, Préciser', target: displayBenefTerme },
        { checkboxId: 'conjoint2', label: 'Le conjoint non divorcé, ni séparé de corps', target: displayBenefDeces },
        { checkboxId: 'enfants2', label: 'Les enfants nés et à naître', target: displayBenefDeces },
        { checkboxId: 'Autres2', label: 'Autres, Préciser (ajouter des bénéficiaires)', target: displayBenefDeces }
    ];

    // Fonction de mise à jour des affichages
    function updateDisplay() {
        // Réinitialiser les affichages
        displayBenefTerme.innerHTML = '';
        displayBenefDeces.innerHTML = '';

        options.forEach(option => {
            const checkbox = document.getElementById(option.checkboxId);
            if (checkbox && checkbox.checked) {
                // Ajouter l'élément sélectionné dans la section appropriée
                const p = document.createElement('p');
                p.textContent = option.label;
                option.target.appendChild(p);
            }
        });
    }

    // Ajouter un event listener pour chaque checkbox
    options.forEach(option => {
        const checkbox = document.getElementById(option.checkboxId);
        if (checkbox) {
            checkbox.addEventListener('change', updateDisplay);
        }
    });

    // Initialiser l'affichage
    updateDisplay();
});
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const stepElement = document.getElementById("test-l-5");
        
        // Initialisation du modal Bootstrap
        const qrModal = new bootstrap.Modal(document.getElementById('qrCodeModal'), {
            keyboard: false,
            backdrop: 'static'
        });

        
        if (stepElement) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(mutation => {
                    if (mutation.attributeName === 'class' && 
                        stepElement.classList.contains('active')) {
                        console.log("Element actif détecté - ouverture du modal");
                        qrModal.show();
                    }
                });
            });
    
            
            observer.observe(stepElement, { 
                attributes: true 
            });
        }

    });


</script>


