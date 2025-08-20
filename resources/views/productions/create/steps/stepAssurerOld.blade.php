<div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
    <h5 class="mb-1">Informations de l'assuré(e)</h5>
    <p class="mb-4">Veuillez entrer les informations relatives à l'assuré(e) en tenant compte des champs obligatoire.</p>

    <div class="row g-3 mb-3">
        {{--  --}}


        {{-- @if ($CodeProduit != "ASSCPTBNI" && Auth::user()->codepartenaire == "CORIS") --}}
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">
            <!-- Button trigger modal -->
            <button type="button" class="btn" data-bs-toggle="modal"
                data-bs-target="#createPropositionModal"><i class="fadeIn animated bx bx-plus"></i>Ajouter un(e) autre
                assuré(e)</button>
            <!-- Modal -->
        </div>
        {{-- @endif --}}
        
        
    </div>

    <style>

        
        .prime-header {
            padding: 15px 20px;
            color: white;
            position: relative;
        }
        
        .prime-header h5 {
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .prime-total-ribbon {
            /* position: absolute; */
            /* top: -10px; */
            right: 20px;
            background: #ff6b6b;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
        }
        
        .ribbon-amount {
            font-size: 1.2em;
        }
        

        .prime-footer {
            margin-top: 20px;
            padding: 10px 15px;
            background: #f8f9fa;
            border-top: 1px solid #eee;
        }
        
        .prime-detail.base td {
            font-weight: 500;
            color: #2c3e50;
        }
        
        .prime-detail.supplement td {
            color: #7f8c8d;
        }
        
        .prime-detail.supplement td:last-child {
            color: #27ae60;
            font-weight: 500;
        }
        
        .table-sm td {
            padding: 8px 5px;
        }
    </style>

    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-9">
            <div style="overflow-x: auto;">
                <table class="table mb-0 table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Assuré(e)</th>
                            <th scope="col">Garanties</th>
                            <th scope="col">Garanties complémentaires</th>
                            <th scope="col">Capital</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    </tbody>
                </table>
                
            </div>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3 ">
            <div id="prime-container" class="card">
                {{-- // Contenu de la prime --}}
            </div>
        </div>
    </div>

 

    <div class="row g-3 mt-4">
        <div class="col-12 d-flex justify-content-between">
            <button onclick="event.preventDefault(); stepper1.previous()" class="btn border-btn px-4 btn-previous-form">
                <i class='bx bx-left-arrow-alt me-2'></i>Précédent
            </button>
            
            <button onclick="event.preventDefault(); stepper1.next()" class="btn btn-two px-4 btn-next-form">
                Suivant <i class='bx bx-right-arrow-alt ms-2'></i>
            </button>
        </div>
    </div>
    
    <!---end row-->

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Constantes pour les primes
        const PRIME_BASE = 23400;
        const FRAIE_ADHESION = 2500;
        
        // Stockage des assurés
        let assures = [];
        const MAX_ENFANTS = 4; // Limite d'enfants à assurer

        const productGarantie = @json($productGarantie);

        // Récupérer l'assuré principal
        const nomAssurePrincipal = document.getElementById('FisrtName')?.value || 'Non défini';
        const prenomAssurePrincipal = document.getElementById('LastName')?.value || 'Non défini';

        // Éléments du DOM
        const form = document.getElementById("AssurAddModal");
        const btnAjouter = document.getElementById("btn-ajouter");
        const lienParenteSelect = document.getElementById("lienParente");
        const btnAjouterAssure = document.querySelector(".btn[data-bs-toggle='modal']");
        const dateNaissanceInput = document.getElementById("datenaissanceAssur");

        // Fonction pour calculer l'âge
        function calculateAge(dateString) {
            if (!dateString) return 0;
            const today = new Date();
            const birthDate = new Date(dateString);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }

        // Fonction pour obtenir les garanties par lien de parenté
        function getGaranties(lienParente) {
            if (!productGarantie) return [];
            
            switch(lienParente) {
                case 'Enfant': 
                    return productGarantie.filter(g => g.CodeProduitGarantie === 'ASSFUN_ENFT');
                case 'Conjoint':
                    return productGarantie.filter(g => g.CodeProduitGarantie === 'ASSFUN_CONJT');
                case 'Autre':
                    return productGarantie.filter(g => g.CodeProduitGarantie === 'ASSFUN_ASCDT');
                case 'Adherent':
                    return productGarantie.filter(g => g.CodeProduitGarantie === 'ASSFUN_ADH');
                default:
                    return [];
            }
        }

        // Fonction pour obtenir le capital par lien de parenté
        function getCapital(lienParente) {
            if (lienParente === 'Enfant' || lienParente === 'Autre') {
                return { 
                    valeur: 500000, 
                    libelle: '500 000 FCFA',
                    editable: false
                };
            } else {
                return {
                    valeur: 1000000,
                    libelle: '1 000 000 FCFA',
                    editable: false,
                };
            }
        }

        // Initialisation avec l'assuré principal
        function initAssurePrincipal() {
            const assurePrincipal = {
                nom: nomAssurePrincipal,
                prenom: prenomAssurePrincipal,
                civilite: '', // À compléter si disponible
                lienParente: 'Adherent',
                garanties: getGaranties('Adherent'),
                capital: getCapital('Adherent'),
                isPrincipal: true
            };
            
            // Vérifier si l'assuré principal n'existe pas déjà
            const exists = assures.some(a => a.isPrincipal);
            if (!exists) {
                assures.unshift(assurePrincipal); // Ajouter en première position
                sessionStorage.setItem("assures", JSON.stringify(assures));
            }
        }

        // Vérifier si on peut ajouter un nouvel enfant
        function canAddChild() {
            const nbEnfants = assures.filter(a => a.lienParente === 'Enfant').length;
            return nbEnfants < MAX_ENFANTS;
        }

        // Mettre à jour l'état du bouton d'ajout
        function updateAddButtonState() {
            if (btnAjouterAssure) {
                if (!canAddChild()) {
                    btnAjouterAssure.disabled = true;
                    btnAjouterAssure.classList.add('disabled');
                    btnAjouterAssure.title = "Vous ne pouvez pas ajouter plus de 4 enfants";
                } else {
                    btnAjouterAssure.disabled = false;
                    btnAjouterAssure.classList.remove('disabled');
                    btnAjouterAssure.title = "";
                }
            }
        }

        // Gestion de l'ajout d'un assuré
        btnAjouter.addEventListener('click', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            
            if (!data.nomAssur || !data.prenomAssur || !data.civiliteAssur || !data.lienParente) {
                alert('Veuillez remplir les champs obligatoires');
                return;
            }

            // Vérification de l'âge pour les enfants
            if (data.lienParente === 'Enfant' && data.datenaissanceAssur) {
                const age = calculateAge(data.datenaissanceAssur);
                if (age < 3) {
                    alert("Vous ne pouvez pas ajouter un enfant de moins de 3 ans");
                    return;
                }
            }

            // Vérification de la limite d'enfants
            if (data.lienParente === 'Enfant' && !canAddChild()) {
                alert(`Vous ne pouvez pas ajouter plus de ${MAX_ENFANTS} enfants`);
                return;
            }

            // Création de l'objet assuré
            const nouvelAssure = {
                nom: data.nomAssur,
                prenom: data.prenomAssur,
                civilite: data.civiliteAssur,
                datenaissance: data.datenaissanceAssur,
                lieuNaissance: data.lieunaissanceAssur,
                naturepieceAssur: data.naturepieceAssur,
                lieuresidenceAssur: data.lieuresidenceAssur,
                lienParente: data.lienParente,
                mobileAssur: data.mobileAssur,
                emailAssur: data.emailAssur,
                numeropieceAssur: data.numeropieceAssur,
                garanties: getGaranties(data.lienParente),
                capital: getCapital(data.lienParente),
                isPrincipal: false
            };

            assures.push(nouvelAssure);
            sessionStorage.setItem("assures", JSON.stringify(assures));
            
            afficherAssures();
            calculerPrimeTotale();
            updateAddButtonState();
            
            // Fermer le modal après ajout
            const modal = bootstrap.Modal.getInstance(document.getElementById('createPropositionModal'));
            if (modal) modal.hide();
            
            form.reset();
        });

        // Affichage des assurés
        function afficherAssures() {
            const tbody = document.querySelector('#test-l-2 tbody');
            if (!tbody) return;

            tbody.innerHTML = '';
            
            assures.forEach((assure, index) => {
                // Liste des garanties
                console.log("assurerrrrrrrrrr".assure);
                const garantiesList = assure.garanties.map(g => 
                    `<li>${g.MonLibelle}</li>`
                ).join('') || '<li>Aucune garantie</li>';
                
                // Affichage du capital (non modifiable)
                const capitalDisplay = assure.capital?.libelle || 'Non défini';

                // Bouton de suppression (non affiché pour l'assuré principal)
                const deleteButton = assure.isPrincipal 
                    ? '<td></td>'
                    : `<td>
                        <a href="#" onclick="supprimerAssure(${index})" class="text-danger">
                            <i class="fadeIn animated bx bx-x fs-4"></i>
                        </a>
                    </td>`;

                // Ligne du tableau
                const row = `
                    <tr>
                        <td>${assure.nom} ${assure.prenom} ${assure.isPrincipal ? '(Assuré principal)' : ''}</td>
                        <td><ul>${garantiesList}</ul></td>
                        <td>Pas de garantie complémentaire</td>
                        <td>${capitalDisplay}</td>
                        ${deleteButton}
                    </tr>
                `;
                
                tbody.innerHTML += row;
            });
        }

        function calculerPrimeTotale() {
            let primeTotale = PRIME_BASE + FRAIE_ADHESION;
            
            // Mettre à jour le champ hidden
            const primePrincipaleInput = document.getElementById('primepricipale');
            if (primePrincipaleInput) {
                primePrincipaleInput.value = primeTotale;
            }

            // Affichage
            const primeContainer = document.getElementById('prime-container');
            if (primeContainer) {
                primeContainer.innerHTML = `
                    <div class="prime-card p-3">
                        <div class="prime-header bg-success text-light">
                            <h5 class="prime-title text-light"><i class="bx bx-calculator"></i> Calcul des primes</h5>
                        </div>
                        <div class="prime-body">
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr class="prime-detail base">
                                        <td>Prime fixe</td>
                                        <td class="text-end">${PRIME_BASE.toLocaleString()} FCFA</td>
                                    </tr>
                                    <tr class="prime-detail base">
                                        <td>FRAIE ADHESION</td>
                                        <td class="text-end">${FRAIE_ADHESION.toLocaleString()} FCFA</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="prime-total-ribbon float-end mt-4 mb-2">
                            <span>Total</span>
                            <div class="ribbon-amount">${primeTotale.toLocaleString()} FCFA</div>
                        </div>
                    </div>
                `;
            }
        }

        // Fonction pour supprimer un assuré
        window.supprimerAssure = function(index) {
            if (assures[index] && !assures[index].isPrincipal) {
                if (confirm("Voulez-vous vraiment supprimer cet assuré ?")) {
                    assures.splice(index, 1);
                    sessionStorage.setItem("assures", JSON.stringify(assures));
                    afficherAssures();
                    calculerPrimeTotale();
                    updateAddButtonState();
                }
            }
        };

        // Chargement initial
        const savedAssures = sessionStorage.getItem("assures");
        if (savedAssures) {
            try {
                assures = JSON.parse(savedAssures);
                // Vérifier si l'assuré principal est présent
                const hasPrincipal = assures.some(a => a.isPrincipal);
                if (!hasPrincipal) {
                    initAssurePrincipal();
                }
            } catch (e) {
                console.error("Erreur de parsing des assurés:", e);
                assures = [];
                initAssurePrincipal();
            }
        } else {
            initAssurePrincipal();
        }

        afficherAssures();
        calculerPrimeTotale();
        updateAddButtonState();
    });
</script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Constantes
        const PRIME_BASE = 23400;
        const FRAIS_ADHESION = 2500;
        const CAPITAL_ADHERENT = 1000000;
        const CAPITAL_ENFANT = 500000;
        
        // Tableau pour stocker les assurés
        let assures = [];
        
        // Récupérer les garanties depuis le backend
        const productGarantie = @json($productGarantie ?? []);
        
        // Initialisation des éléments
        const firstNameInput = document.getElementById('FisrtName');
        const lastNameInput = document.getElementById('LastName');
        const ulGarantiesAdherent = document.getElementById('garanties-adherent');
        const modal = bootstrap.Modal.getInstance(document.getElementById('createPropositionModal')) || 
                      new bootstrap.Modal(document.getElementById('createPropositionModal'));

        // Initialisation des garanties pour l'adhérent
        if (ulGarantiesAdherent) {
            ulGarantiesAdherent.innerHTML = '';
            const garantiesAdherent = getGarantiesByLienParente('Adherent');
            garantiesAdherent.forEach(garantie => {
                const li = document.createElement('li');
                li.textContent = garantie.MonLibelle;
                ulGarantiesAdherent.appendChild(li);
            });
        }

        // Mettre à jour l'affichage du nom/prénom
        if (firstNameInput && lastNameInput) {
            firstNameInput.addEventListener('input', updateDisplay);
            lastNameInput.addEventListener('input', updateDisplay);
            updateDisplay(); // Initialiser l'affichage
        }

        function updateDisplay() {
            const displayElement = document.getElementById('display-nom-prenom');
            if (displayElement && firstNameInput && lastNameInput) {
                displayElement.textContent = `${firstNameInput.value} ${lastNameInput.value}`.trim();
            }
        }
        
        // Fonctions utilitaires
        function getGarantiesByLienParente(lienParente) {
            if (!Array.isArray(productGarantie)) return [];
            
            switch(lienParente) {
                case 'Enfant': return productGarantie.filter(g => g?.CodeProduitGarantie === 'ASSFUN_ENFT');
                case 'Conjoint': return productGarantie.filter(g => g?.CodeProduitGarantie === 'ASSFUN_CONJT');
                case 'Autre': return productGarantie.filter(g => g?.CodeProduitGarantie === 'ASSFUN_ASCDT');
                case 'Adherent': return productGarantie.filter(g => g?.CodeProduitGarantie === 'ASSFUN_ADH');
                default: return [];
            }
        }

        function formatNumber(number) {
            return new Intl.NumberFormat('fr-FR', { 
                minimumFractionDigits: 2,
                maximumFractionDigits: 2 
            }).format(number);
        }

        // Fonction pour ajouter un assuré
        function ajouterAssureTemporaire() {
            const modalForm = document.querySelector('#createPropositionModal form');
            if (!modalForm) return;

            const nom = modalForm.querySelector('[name="nomAssur"]')?.value;
            const prenom = modalForm.querySelector('[name="prenomAssur"]')?.value;
            const civilite = modalForm.querySelector('input[name="civiliteAssur"]:checked')?.value;
            const lienParente = modalForm.querySelector('[name="lienParente"]')?.value;

            if (!nom || !prenom || !civilite || !lienParente) {
                alert("Veuillez remplir tous les champs obligatoires");
                return;
            }

            const nouvelAssure = {
                nom, 
                prenom, 
                civilite,
                datenaissance: modalForm.querySelector('[name="datenaissanceAssur"]')?.value || '',
                lienParente,
                capital: lienParente === 'Enfant' ? CAPITAL_ENFANT : CAPITAL_ADHERENT,
                garanties: getGarantiesByLienParente(lienParente)
            };

            assures.push(nouvelAssure);
            sessionStorage.setItem("assures", JSON.stringify(assures));
            
            afficherAssures();
            modal.hide();
            modalForm.reset();
        }

        // Fonction pour afficher les assurés
        function afficherAssures() {
            const tbody = document.querySelector('#test-l-2 tbody');
            if (!tbody) return;

            tbody.innerHTML = '';
            
            assures.forEach((assure, index) => {
                const row = document.createElement('tr');
                
                // Colonnes du tableau
                row.innerHTML = `
                    <td>${assure.nom} ${assure.prenom}</td>
                    <td>${assure.lienParente}</td>
                    <td>
                        <ul>
                            ${assure.garanties?.map(g => `<li>${g.MonLibelle}</li>`).join('') || '<li>Pas de garantie</li>'}
                        </ul>
                    </td>
                    <td>${formatNumber(assure.capital)}</td>
                    <td>
                        <a href="#" class="text-primary me-2" onclick="event.preventDefault(); editAssure(${index})">
                            <i class="fadeIn animated bx bx-edit fs-4"></i>
                        </a>
                        <a href="#" class="text-danger" onclick="event.preventDefault(); supprimerAssure(${index})">
                            <i class="fadeIn animated bx bx-x fs-4"></i>
                        </a>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        // Fonction pour éditer un assuré
        function editAssure(index) {
            const assure = assures[index];
            if (!assure) return;
            
            // Remplir le formulaire avec les données de l'assuré
            const form = document.querySelector('#createPropositionModal form');
            if (!form) return;
            
            // Remplir les champs du formulaire
            form.querySelector('[name="nomAssur"]').value = assure.nom;
            form.querySelector('[name="prenomAssur"]').value = assure.prenom;
            form.querySelector(`input[name="civiliteAssur"][value="${assure.civilite}"]`).checked = true;
            form.querySelector('[name="datenaissanceAssur"]').value = assure.datenaissance;
            form.querySelector('[name="lieunaissanceAssur"]').value = assure.lieuNaissance;
            form.querySelector('[name="lieuresidenceAssur"]').value = assure.lieuresidenceAssur;
            form.querySelector('[name="filiation"]').value = assure.filiation;
            form.querySelector('[name="mobileAssur"]').value = assure.mobileAssur;
            form.querySelector('[name="emailAssur"]').value = assure.emailAssur;
            form.querySelector('[name="naturepieceAssur"]').value = assure.naturepieceAssur;
            form.querySelector('[name="lienParente"]').value = assure.lienParente;
            
            // Stocker l'index de l'assuré en cours d'édition
            form.dataset.editIndex = index;
            
            // Modifier le texte du bouton
            const btn = document.querySelector('#createPropositionModal .btn-primary');
            if (btn) {
                btn.textContent = 'Modifier';
                btn.onclick = function() {
                    modifierAssure(index);
                };
            }
            
            // Ouvrir le modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('createPropositionModal'));
            modal.show();
        }

        // Fonction pour modifier un assuré existant
        function modifierAssure(index) {
            try {
                const form = document.querySelector('#createPropositionModal form');
                if (!form) throw new Error("Formulaire non trouvé");

                const dateNaissance = form.querySelector('[name="datenaissanceAssur"]')?.value;
                const lienParente = form.querySelector('[name="lienParente"]')?.value;
                
                // Validation de l'âge en fonction de la filiation
                if (dateNaissance) {
                    const age = calculateAge(dateNaissance);
                    
                    if (lienParente === 'Enfant') {
                        if (age < 3 || age > 24) {
                            swal.fire("Erreur", "Un enfant doit avoir entre 3 et 24 ans", "error");
                            return;
                        }
                    } else {
                        if (age < 18 || age > 70) {
                            swal.fire("Erreur", "L'assuré doit avoir entre 18 et 70 ans", "error");
                            return;
                        }
                    }
                } else {
                    throw new Error("La date de naissance est obligatoire");
                }

                const assureModifie = {
                    nom: form.querySelector('[name="nomAssur"]')?.value || '',
                    prenom: form.querySelector('[name="prenomAssur"]')?.value || '',
                    civilite: form.querySelector('input[name="civiliteAssur"]:checked')?.value || '',
                    datenaissance: form.querySelector('[name="datenaissanceAssur"]')?.value || '',
                    lieuNaissance: form.querySelector('[name="lieunaissanceAssur"]')?.value || '',
                    lieuresidenceAssur: form.querySelector('[name="lieuresidenceAssur"]')?.value || '',
                    filiation: form.querySelector('[name="filiation"]')?.value || '',
                    mobileAssur: form.querySelector('[name="mobileAssur"]')?.value || '',
                    emailAssur: form.querySelector('[name="emailAssur"]')?.value || '',
                    naturepieceAssur: form.querySelector('[name="naturepieceAssur"]')?.value || '',
                    lienParente: form.querySelector('[name="lienParente"]')?.value || '',
                    capital: form.querySelector('[name="lienParente"]')?.value === 'Enfant' ? CAPITAL_ENFANT : CAPITAL_ADHERENT,
                    garanties: getGarantiesByLienParente(form.querySelector('[name="lienParente"]')?.value)
                };
                
                if (!assureModifie.nom || !assureModifie.prenom || !assureModifie.civilite || !assureModifie.lienParente) {
                    throw new Error("Veuillez remplir tous les champs obligatoires");
                }
                
                // Mettre à jour l'assuré dans le tableau
                assures[index] = assureModifie;
                sessionStorage.setItem("assures", JSON.stringify(assures));
                document.getElementById('assuresInput').value = JSON.stringify(assures);
                
                afficherAssures();
                afficherResumeAssures();
                updatePrimeTotale();
                
                // Réinitialiser et fermer le modal
                const modalElement = document.getElementById('createPropositionModal');
                const bootstrapModal = bootstrap.Modal.getInstance(modalElement);
                form.reset();
                delete form.dataset.editIndex;
                
                // Restaurer le bouton d'ajout
                const btn = document.querySelector('#createPropositionModal .btn-primary');
                if (btn) {
                    btn.textContent = 'Ajouter';
                    btn.onclick = ajouterAssureTemporaire;
                }
                
                bootstrapModal.hide();
            } catch (error) {
                console.error("Erreur lors de la modification d'un assuré:", error);
            }
        }

        // Fonction pour supprimer un assuré
        function supprimerAssure(index) {
            if (confirm("Voulez-vous vraiment supprimer cet assuré ?")) {
                assures.splice(index, 1);
                sessionStorage.setItem("assures", JSON.stringify(assures));
                afficherAssures();
            }
        }

        // Initialisation
        function init() {
            // Réinitialiser pour nouvelle souscription
            assures = [];
            sessionStorage.removeItem("assures");

            // Ajouter le souscripteur comme adhérent
            if (firstNameInput?.value && lastNameInput?.value) {
                assures.push({
                    nom: firstNameInput.value,
                    prenom: lastNameInput.value,
                    lienParente: 'Adherent',
                    capital: CAPITAL_ADHERENT,
                    garanties: getGarantiesByLienParente('Adherent')
                });
                sessionStorage.setItem("assures", JSON.stringify(assures));
            }

            afficherAssures();
            
            // Gestion du bouton d'ajout
            const btnAjouter = document.querySelector('#createPropositionModal .btn-primary');
            if (btnAjouter) {
                btnAjouter.addEventListener('click', ajouterAssureTemporaire);
            }
        }

        // Exposer les fonctions globales
        window.ajouterAssureTemporaire = ajouterAssureTemporaire;
        window.supprimerAssure = supprimerAssure;
        window.editAssure = editAssure;
        window.modifierAssure = modifierAssure;

        // Démarrer
        init();
    });
</script> --}}


