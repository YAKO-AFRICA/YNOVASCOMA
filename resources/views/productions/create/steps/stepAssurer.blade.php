<div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
    <h5 class="mb-1">Informations de l'assuré(e)</h5>
    <p class="mb-4">Veuillez entrer les informations relatives à l'assuré(e) en tenant compte des champs obligatoire.</p>

    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-6">
            <label for="" class="form-label">Le souscripteur est-il l'assuré ?</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estAssure" id="Oui" value="Oui" checked>
                <label class="form-check-label" for="Oui">Oui</label>
            </div>
        </div>

        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">
            <button type="button" class="btn" data-bs-toggle="modal"
                data-bs-target="#createPropositionModal"><i class="fadeIn animated bx bx-plus"></i>Ajouter un(e) autre
                assuré(e)</button>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table class="table mb-0 table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Assuré(e)</th>
                    <th scope="col">Lien de parenté</th>
                    <th scope="col">Garanties</th>
                    <th scope="col">Capital</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            
            <tbody>
            </tbody>
    
            <tfoot>
                <tr id="conditional-tr">
                    <td id="display-nom-prenom"></td>
                    <td>Adhérent</td>
                    <td>
                        <ul id="garanties-adherent">
                            <!-- Les garanties pour l'adhérent seront insérées ici -->
                        </ul>
                    </td>
                    <td id="capital-adherent">1,000,000.00</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
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
</div>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Constantes
        const PRIME_BASE = 25000;
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
        const modalElement = document.getElementById('createPropositionModal');
        const modal = modalElement ? new bootstrap.Modal(modalElement) : null;

        // Initialiser les garanties pour l'adhérent
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
            updateDisplay();
        }

        function updateDisplay() {
            const displayElement = document.getElementById('display-nom-prenom');
            if (displayElement && firstNameInput && lastNameInput) {
                displayElement.textContent = `${firstNameInput.value} ${lastNameInput.value}`.trim();
            }
        }
        
        // Fonction pour obtenir les garanties selon le lien de parenté
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

        // Fonction pour calculer l'âge à partir d'une date de naissance
        function calculerAge(dateNaissance) {
            const today = new Date();
            const birthDate = new Date(dateNaissance);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            return age;
        }

        // Fonction pour valider l'âge selon le lien de parenté
        function validerAge(dateNaissance, lienParente) {
            const age = calculerAge(dateNaissance);
            
            switch(lienParente) {
                case 'Conjoint':
                    return age >= 18 && age <= 64;
                case 'Enfant':
                    return age >= 3 && age <= 24;
                case 'Autre':
                    return age >= 18 && age <= 70;
                default:
                    return true;
            }
        }

        // Fonction pour vérifier si un conjoint existe déjà
        function conjointExisteDeja() {
            return assures.some(assure => assure.lienParente === 'Conjoint');
        }

        // Fonction pour compter le nombre d'enfants
        function nombreEnfants() {
            return assures.filter(assure => assure.lienParente === 'Enfant').length;
        }

        // Fonction pour ajouter un assuré
        function ajouterAssureTemporaire() {
            try {
                const form = document.querySelector('#createPropositionModal form');
                if (!form) throw new Error("Formulaire non trouvé");
                
                const lienParente = form.querySelector('[name="lienParente"]')?.value || '';
                const dateNaissance = form.querySelector('[name="datenaissanceAssur"]')?.value || '';
                
                // Validation spécifique pour le conjoint
                if (lienParente === 'Conjoint' && conjointExisteDeja()) {
                    swal.fire("Erreur", "Un seul conjoint peut être ajouté", "error");
                    // throw new Error("Un seul conjoint peut être ajouté");
                }
                
                // Validation spécifique pour les enfants
                if (lienParente === 'Enfant' && nombreEnfants() >= 4) {
                    swal.fire("Erreur", "Maximum 4 enfants peuvent'être ajoutés", "error");
                    // throw new Error("Maximum 4 enfants peuvent être ajoutés");
                }
                
                // Validation de l'âge
                if (dateNaissance && !validerAge(dateNaissance, lienParente)) {
                    let message = "Âge non valide pour ce type d'assuré. ";
                    switch(lienParente) {
                        case 'Conjoint':
                            message += "Le conjoint doit avoir entre 18 et 64 ans";
                            break;
                        case 'Enfant':
                            message += "L'enfant doit avoir entre 3 et 24 ans";
                            break;
                        case 'Autre':
                            message += "L'assuré doit avoir entre 18 et 70 ans";
                            break;
                    }
                    throw new Error(message);
                }
                
                const nouvelAssure = {
                    nom: form.querySelector('[name="nomAssur"]')?.value || '',
                    prenom: form.querySelector('[name="prenomAssur"]')?.value || '',
                    civilite: form.querySelector('input[name="civiliteAssur"]:checked')?.value || '',
                    datenaissance: dateNaissance,
                    lieuNaissance: form.querySelector('[name="lieunaissanceAssur"]')?.value || '',
                    lieuresidenceAssur: form.querySelector('[name="lieuresidenceAssur"]')?.value || '',
                    filiation: form.querySelector('[name="filiation"]')?.value || '',
                    mobileAssur: form.querySelector('[name="mobileAssur"]')?.value || '',
                    emailAssur: form.querySelector('[name="emailAssur"]')?.value || '',
                    naturepieceAssur: form.querySelector('[name="naturepieceAssur"]')?.value || '',
                    lienParente: lienParente,
                    capital: lienParente === 'Enfant' ? CAPITAL_ENFANT : CAPITAL_ADHERENT,
                    garanties: getGarantiesByLienParente(lienParente)
                };
                
                // Validation des champs obligatoires
                if (!nouvelAssure.nom || !nouvelAssure.prenom || !nouvelAssure.civilite || !nouvelAssure.lienParente) {
                    throw new Error("Veuillez remplir tous les champs obligatoires");
                }
                
                assures.push(nouvelAssure);
                sessionStorage.setItem("assures", JSON.stringify(assures));

                document.getElementById('assuresInput').value = JSON.stringify(assures);
                
                afficherAssures();
                afficherResumeAssures();
                // updatePrimeTotale();
                
                const bootstrapModal = bootstrap.Modal.getInstance(modalElement);
                form.reset();
                bootstrapModal.hide();
            } catch (error) {
                console.error("Erreur lors de l'ajout d'un assuré:", error);
                alert(error.message);
            }
        }

        // Fonction pour afficher les assurés dans le tableau principal
        function afficherAssures() {
            const tbody = document.querySelector('#test-l-2 tbody');
            if (!tbody) return;

            tbody.innerHTML = '';
            
            assures.forEach((assure, index) => {
                const row = document.createElement('tr');
                
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
                        <a href="#" class="text-danger" onclick="event.preventDefault(); supprimerAssure(${index})">
                            <i class="fadeIn animated bx bx-x fs-4"></i>
                        </a>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        // Fonction pour afficher le résumé des assurés
        function afficherResumeAssures() {
            const tbodyResume = document.getElementById('resumAssur');
            if (!tbodyResume) return;

            tbodyResume.innerHTML = '';

            assures.forEach(assure => {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td>${assure.nom}</td>
                    <td>${assure.prenom}</td>
                    <td>${assure.datenaissance || ''}</td>
                    <td>${assure.lieuNaissance || ''}</td>
                    <td>${assure.lieuresidenceAssur || ''}</td>
                    <td>${assure.filiation || ''}</td>
                    <td>
                        <ul>
                            ${assure.garanties?.map(g => `<li>${g.MonLibelle}</li>`).join('') || '<li>Pas de garantie</li>'}
                        </ul>
                    </td>
                    <td>${assure.mobileAssur || ''}</td>
                    <td>${assure.emailAssur || ''}</td>
                    <td>${assure.naturepieceAssur || ''}</td>
                `;
                
                tbodyResume.appendChild(row);
            });
        }

        // Fonction pour supprimer un assuré
        function supprimerAssure(index) {
            if (confirm("Voulez-vous vraiment supprimer cet assuré ?")) {
                assures.splice(index, 1);
                sessionStorage.setItem("assures", JSON.stringify(assures));
                afficherAssures();
                afficherResumeAssures();
                // updatePrimeTotale();
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
                    garanties: getGarantiesByLienParente('Adherent'),
                    // Champs supplémentaires avec valeurs par défaut
                    datenaissance: '',
                    lieuNaissance: '',
                    lieuresidenceAssur: '',
                    filiation: '',
                    mobileAssur: '',
                    emailAssur: '',
                    naturepieceAssur: ''
                });
                sessionStorage.setItem("assures", JSON.stringify(assures));
            }

            afficherAssures();
            afficherResumeAssures();
            // updatePrimeTotale();
            
            // Gestion du bouton d'ajout
            const btnAjouter = document.querySelector('#createPropositionModal .btn-primary');
            if (btnAjouter) {
                btnAjouter.addEventListener('click', ajouterAssureTemporaire);
            }

            // Désactiver les options de lien de parenté selon les règles
            const selectLienParente = document.querySelector('[name="lienParente"]');
            if (selectLienParente) {
                selectLienParente.addEventListener('change', function() {
                    const optionConjoint = this.querySelector('option[value="Conjoint"]');
                    const optionEnfant = this.querySelector('option[value="Enfant"]');
                    
                    if (optionConjoint) {
                        optionConjoint.disabled = conjointExisteDeja();
                    }
                    
                    if (optionEnfant) {
                        optionEnfant.disabled = nombreEnfants() >= 4;
                    }
                });
            }
        }

        // Exposer les fonctions globales
        window.ajouterAssureTemporaire = ajouterAssureTemporaire;
        window.supprimerAssure = supprimerAssure;

        // Démarrer
        init();
    });
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Constantes
        const PRIME_BASE = 25000;
        const FRAIS_ADHESION = 2500;
        const CAPITAL_ADHERENT = 1000000;
        const CAPITAL_ENFANT = 500000;
        
        // Tableau pour stocker les assurés
        let assures = [];
        let assureEnModification = null; // Pour tracker l'assuré en cours de modification
        
        // Récupérer les garanties depuis le backend
        const productGarantie = @json($productGarantie ?? []);
        
        // Initialisation des éléments
        const firstNameInput = document.getElementById('FisrtName');
        const lastNameInput = document.getElementById('LastName');
        const ulGarantiesAdherent = document.getElementById('garanties-adherent');
        const modalElement = document.getElementById('createPropositionModal');
        const modal = modalElement ? new bootstrap.Modal(modalElement) : null;

        // Initialiser les garanties pour l'adhérent
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
            updateDisplay();
        }

        function updateDisplay() {
            const displayElement = document.getElementById('display-nom-prenom');
            if (displayElement && firstNameInput && lastNameInput) {
                displayElement.textContent = `${firstNameInput.value} ${lastNameInput.value}`.trim();
            }
        }
        
        // Fonction pour obtenir les garanties selon le lien de parenté
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

        // Fonction pour calculer l'âge à partir d'une date de naissance
        function calculerAge(dateNaissance) {
            const today = new Date();
            const birthDate = new Date(dateNaissance);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            return age;
        }

        // Fonction pour valider l'âge selon le lien de parenté
        function validerAge(dateNaissance, lienParente) {
            const age = calculerAge(dateNaissance);
            
            switch(lienParente) {
                case 'Conjoint':
                    return age >= 18 && age <= 64;
                case 'Enfant':
                    return age >= 3 && age <= 24;
                case 'Autre':
                    return age >= 18 && age <= 70;
                default:
                    return true;
            }
        }

        // Fonction pour vérifier si un conjoint existe déjà
        function conjointExisteDeja(excludeIndex = -1) {
            return assures.some((assure, index) => assure.lienParente === 'Conjoint' && index !== excludeIndex);
        }

        // Fonction pour compter le nombre d'enfants
        function nombreEnfants(excludeIndex = -1) {
            return assures.filter((assure, index) => assure.lienParente === 'Enfant' && index !== excludeIndex).length;
        }

        // Fonction pour valider les champs obligatoires
        function validerChampsObligatoires(form) {
            const champsObligatoires = {
                nom: form.querySelector('[name="nomAssur"]')?.value?.trim() || '',
                prenom: form.querySelector('[name="prenomAssur"]')?.value?.trim() || '',
                dateNaissance: form.querySelector('[name="datenaissanceAssur"]')?.value || '',
                lienParente: form.querySelector('[name="lienParente"]')?.value || '',
                civilite: form.querySelector('input[name="civiliteAssur"]:checked')?.value || ''
            };

            const erreurs = [];

            if (!champsObligatoires.nom) {
                erreurs.push("Le nom est obligatoire");
            }

            if (!champsObligatoires.prenom) {
                erreurs.push("Le prénom est obligatoire");
            }

            if (!champsObligatoires.dateNaissance) {
                erreurs.push("La date de naissance est obligatoire");
            }

            if (!champsObligatoires.lienParente) {
                erreurs.push("Le lien de parenté est obligatoire");
            }

            if (!champsObligatoires.civilite) {
                erreurs.push("La civilité est obligatoire");
            }

            return {
                valide: erreurs.length === 0,
                erreurs: erreurs,
                donnees: champsObligatoires
            };
        }

        // Fonction pour ajouter un assuré
        function ajouterAssureTemporaire() {
            try {
                const form = document.querySelector('#createPropositionModal form');
                if (!form) throw new Error("Formulaire non trouvé");
                
                // Validation des champs obligatoires
                const validation = validerChampsObligatoires(form);
                if (!validation.valide) {
                    swal.fire("Erreur", validation.erreurs.join('\n'), "error");
                    return;
                }

                const lienParente = validation.donnees.lienParente;
                const dateNaissance = validation.donnees.dateNaissance;
                
                // Validation spécifique pour le conjoint
                if (lienParente === 'Conjoint' && conjointExisteDeja()) {
                    swal.fire("Erreur", "Un seul conjoint peut être ajouté", "error");
                    return;
                }
                
                // Validation spécifique pour les enfants
                if (lienParente === 'Enfant' && nombreEnfants() >= 4) {
                    swal.fire("Erreur", "Maximum 4 enfants peuvent être ajoutés", "error");
                    return;
                }
                
                // Validation de l'âge
                if (dateNaissance && !validerAge(dateNaissance, lienParente)) {
                    let message = "Âge non valide pour ce type d'assuré. ";
                    switch(lienParente) {
                        case 'Conjoint':
                            message += "Le conjoint doit avoir entre 18 et 64 ans";
                            break;
                        case 'Enfant':
                            message += "L'enfant doit avoir entre 3 et 24 ans";
                            break;
                        case 'Autre':
                            message += "L'assuré doit avoir entre 18 et 70 ans";
                            break;
                    }
                    swal.fire("Erreur", message, "error");
                    return;
                }
                
                const nouvelAssure = {
                    nom: validation.donnees.nom,
                    prenom: validation.donnees.prenom,
                    civilite: validation.donnees.civilite,
                    datenaissance: dateNaissance,
                    lieuNaissance: form.querySelector('[name="lieunaissanceAssur"]')?.value || '',
                    lieuresidenceAssur: form.querySelector('[name="lieuresidenceAssur"]')?.value || '',
                    filiation: form.querySelector('[name="filiation"]')?.value || '',
                    mobileAssur: form.querySelector('[name="mobileAssur"]')?.value || '',
                    emailAssur: form.querySelector('[name="emailAssur"]')?.value || '',
                    naturepieceAssur: form.querySelector('[name="naturepieceAssur"]')?.value || '',
                    numeropieceAssur: form.querySelector('[name="numeropieceAssur"]')?.value || '',
                    lienParente: lienParente,
                    capital: lienParente === 'Enfant' ? CAPITAL_ENFANT : CAPITAL_ADHERENT,
                    garanties: getGarantiesByLienParente(lienParente)
                };
                
                assures.push(nouvelAssure);
                sessionStorage.setItem("assures", JSON.stringify(assures));

                document.getElementById('assuresInput').value = JSON.stringify(assures);
                
                afficherAssures();
                afficherResumeAssures();
                
                const bootstrapModal = bootstrap.Modal.getInstance(modalElement);
                form.reset();
                bootstrapModal.hide();

                swal.fire("Succès", "Assuré ajouté avec succès", "success");
                
            } catch (error) {
                console.error("Erreur lors de l'ajout d'un assuré:", error);
                swal.fire("Erreur", error.message, "error");
            }
        }

        // Fonction pour modifier un assuré
        function modifierAssure(index) {
            if (index < 0 || index >= assures.length) {
                swal.fire("Erreur", "Assuré non trouvé", "error");
                return;
            }

            assureEnModification = index;
            const assure = assures[index];
            
            // Remplir le modal d'édition avec les données existantes
            const modalEdit = document.getElementById(`modalAssurEdit${index}`);
            if (!modalEdit) {
                // Si le modal spécifique n'existe pas, créer un modal générique
                creerModalEdition(assure, index);
                return;
            }

            const form = modalEdit.querySelector('form');
            if (form) {
                form.querySelector('[name="nomAssur"]').value = assure.nom || '';
                form.querySelector('[name="prenomAssur"]').value = assure.prenom || '';
            }

            getGarantiesByLienParente(assure.lienParente)

            // Ouvrir le modal
            const bootstrapModal = new bootstrap.Modal(modalEdit);
            bootstrapModal.show();
        }

        // Fonction pour créer un modal d'édition générique
        // function creerModalEdition(assure, index) {
        //     const modalId = `modalAssurEditGeneric`;
        //     let existingModal = document.getElementById(modalId);
            
        //     if (existingModal) {
        //         existingModal.remove();
        //     }

        //     const modalHTML = `
        //         <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
        //             <div class="modal-dialog modal-lg">
        //                 <div class="modal-content">
        //                     <div class="modal-header">
        //                         <h5 class="modal-title">Modifier un Assuré</h5>
        //                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        //                     </div>
        //                     <div class="modal-body">
        //                         <div class="card">
        //                             <div class="card-body">
        //                                 <form id="AssurEditModalForm">
        //                                     <div class="col-12 col-lg-6 mb-3">
        //                                         <label for="civiliteAssurEdit" class="form-label">Civilité <span class="star">*</span></label>
        //                                         <div class="form-check form-check-inline">
        //                                             <input class="form-check-input" type="radio" name="civiliteAssurEdit" value="Madame" ${assure.civilite === 'Madame' ? 'checked' : ''}>
        //                                             <label class="form-check-label">Madame</label>
        //                                         </div>
        //                                         <div class="form-check form-check-inline">
        //                                             <input class="form-check-input" type="radio" name="civiliteAssurEdit" value="Mademoiselle" ${assure.civilite === 'Mademoiselle' ? 'checked' : ''}>
        //                                             <label class="form-check-label">Mademoiselle</label>
        //                                         </div>
        //                                         <div class="form-check form-check-inline">
        //                                             <input class="form-check-input" type="radio" name="civiliteAssurEdit" value="Monsieur" ${assure.civilite === 'Monsieur' ? 'checked' : ''}>
        //                                             <label class="form-check-label">Monsieur</label>
        //                                         </div>
        //                                     </div>
        //                                     <div class="row g-3 mb-3">
        //                                         <div class="col-12 col-lg-6">
        //                                             <label for="nomAssurEdit" class="form-label">Nom de l'assuré <span class="star">*</span></label>
        //                                             <input type="text" name="nomAssurEdit" class="form-control" value="${assure.nom || ''}" placeholder="Nom">
        //                                         </div>
        //                                         <div class="col-12 col-lg-6">
        //                                             <label for="prenomAssurEdit" class="form-label">Prénoms de l'assuré <span class="star">*</span></label>
        //                                             <input type="text" name="prenomAssurEdit" class="form-control" value="${assure.prenom || ''}" placeholder="Prénoms">
        //                                         </div>
        //                                     </div>
        //                                     <div class="row g-3 mb-3">
        //                                         <div class="col-12 col-lg-6">
        //                                             <label for="datenaissanceAssurEdit" class="form-label">Date de naissance <span class="star">*</span></label>
        //                                             <input type="date" name="datenaissanceAssurEdit" class="form-control" value="${assure.datenaissance || ''}">
        //                                         </div>
        //                                         <div class="col-12 col-lg-6">
        //                                             <label for="mobileAssurEdit" class="form-label">Téléphone</label>
        //                                             <input type="text" name="mobileAssurEdit" class="form-control" value="${assure.mobileAssur || ''}">
        //                                         </div>
        //                                     </div>
        //                                     <div class="row g-3 mb-3">
                                                
        //                                         <div class="col-12 col-lg-6">
        //                                             <label for="lienParenteAssurEdit" class="form-label">Lien de Parenté</label>
        //                                             <select class="form-select" name="lienParenteAssurEdit" id="lienParenteAssurEdit"
        //                                                 aria-label="Default select example" value="${assure.lienParente || ''}">
        //                                                 <option selected disabled>Sélectionner le lien de Parenté</option>
        //                                                 <option value="Conjoint">Conjoint</option>
        //                                                 <option value="Enfant">Enfant</option>
        //                                                 <option value="Autre">Autre</option> 
        //                                             </select>
        //                                         </div> 

        //                                         <div class="col-12 col-lg-6">
        //                                             <label for="numPieceAssurEdit" class="form-label">N° de piece <span class="star">*</span></label>
        //                                             <input type="date" name="numPieceAssurEdit" class="form-control" value="${assure.datenaissance || ''}">
        //                                         </div>
        //                                     </div>
        //                                     <div class="col-12">
        //                                         <div class="d-flex align-items-center gap-3">
        //                                             <button type="button" class="btn border-btn px-4" data-bs-dismiss="modal">Annuler</button>
        //                                             <button type="button" class="btn btn-two px-4" onclick="sauvegarderModification()">Modifier</button>
        //                                         </div>
        //                                     </div>
        //                                 </form>
        //                             </div>
        //                         </div>
        //                     </div>
        //                 </div>
        //             </div>
        //         </div>
        //     `;

        //     document.body.insertAdjacentHTML('beforeend', modalHTML);
            
        //     const modalEdit = document.getElementById(modalId);
        //     const bootstrapModal = new bootstrap.Modal(modalEdit);
        //     bootstrapModal.show();
        // }

        function creerModalEdition(assure, index) {
            const modalId = `modalAssurEditGeneric`;
            let existingModal = document.getElementById(modalId);
            
            if (existingModal) {
                existingModal.remove();
            }

            const modalHTML = `
                <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Modifier un Assuré</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="AssurEditModalForm">
                                            <div class="col-12 col-lg-6 mb-3">
                                                <label for="civiliteAssurEdit" class="form-label">Civilité <span class="star">*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="civiliteAssurEdit" value="Madame" ${assure.civilite === 'Madame' ? 'checked' : ''}>
                                                    <label class="form-check-label">Madame</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="civiliteAssurEdit" value="Mademoiselle" ${assure.civilite === 'Mademoiselle' ? 'checked' : ''}>
                                                    <label class="form-check-label">Mademoiselle</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="civiliteAssurEdit" value="Monsieur" ${assure.civilite === 'Monsieur' ? 'checked' : ''}>
                                                    <label class="form-check-label">Monsieur</label>
                                                </div>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-12 col-lg-6">
                                                    <label for="nomAssurEdit" class="form-label">Nom de l'assuré <span class="star">*</span></label>
                                                    <input type="text" name="nomAssurEdit" class="form-control" value="${assure.nom || ''}" placeholder="Nom">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="prenomAssurEdit" class="form-label">Prénoms de l'assuré <span class="star">*</span></label>
                                                    <input type="text" name="prenomAssurEdit" class="form-control" value="${assure.prenom || ''}" placeholder="Prénoms">
                                                </div>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-12 col-lg-6">
                                                    <label for="datenaissanceAssurEdit" class="form-label">Date de naissance <span class="star">*</span></label>
                                                    <input type="date" name="datenaissanceAssurEdit" class="form-control" value="${assure.datenaissance || ''}">
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="mobileAssurEdit" class="form-label">Téléphone</label>
                                                    <input type="text" name="mobileAssurEdit" class="form-control" value="${assure.mobileAssur || ''}">
                                                </div>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-12 col-lg-6">
                                                    <label for="lienParenteAssurEdit" class="form-label">Lien de Parenté</label>
                                                    <select class="form-select" name="lienParenteAssurEdit" id="lienParenteAssurEdit">
                                                        <option selected disabled>Sélectionner le lien de Parenté</option>
                                                        <option value="Conjoint" ${assure.lienParente === 'Conjoint' ? 'selected' : ''}>Conjoint</option>
                                                        <option value="Enfant" ${assure.lienParente === 'Enfant' ? 'selected' : ''}>Enfant</option>
                                                        <option value="Autre" ${assure.lienParente === 'Autre' ? 'selected' : ''}>Autre</option> 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-12 col-lg-6">
                                                    <label for="naturepieceAssurEdit" class="form-label">Nature de la pièce</label>
                                                    <select class="form-select" name="naturepieceAssurEdit" id="naturepieceAssurEdit">
                                                        <option value="" ${!assure.naturepieceAssur ? 'selected' : ''}>Sélectionner</option>
                                                        <option value="CNI" ${assure.naturepieceAssur === 'CNI' ? 'selected' : ''}>Carte Nationale d'Identité</option>
                                                        <option value="Passeport" ${assure.naturepieceAssur === 'Passeport' ? 'selected' : ''}>Passeport</option>
                                                        <option value="Permis" ${assure.naturepieceAssur === 'Permis' ? 'selected' : ''}>Permis de conduire</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="numeropieceAssurEdit" class="form-label">N° de pièce <span class="star">*</span></label>
                                                    <input type="text" name="numeropieceAssurEdit" class="form-control" value="${assure.numeropieceAssur || ''}" placeholder="Numéro de pièce">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center gap-3">
                                                    <button type="button" class="btn border-btn px-4" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="button" class="btn btn-two px-4" onclick="sauvegarderModification()">Modifier</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', modalHTML);
            
            const modalEdit = document.getElementById(modalId);
            const bootstrapModal = new bootstrap.Modal(modalEdit);
            bootstrapModal.show();
        }

        // Fonction pour sauvegarder les modifications
        // function sauvegarderModification() {
        //     try {
        //         if (assureEnModification === null) {
        //             throw new Error("Aucun assuré en cours de modification");
        //         }

        //         const form = document.querySelector('#AssurEditModalForm');
        //         if (!form) {
        //             throw new Error("Formulaire de modification non trouvé");
        //         }

        //         // Validation des champs obligatoires pour l'édition
        //         const nom = form.querySelector('[name="nomAssurEdit"]')?.value?.trim() || '';
        //         const prenom = form.querySelector('[name="prenomAssurEdit"]')?.value?.trim() || '';
        //         const dateNaissance = form.querySelector('[name="datenaissanceAssurEdit"]')?.value || '';
        //         const civilite = form.querySelector('input[name="civiliteAssurEdit"]:checked')?.value || '';

        //         const erreurs = [];
        //         if (!nom) erreurs.push("Le nom est obligatoire");
        //         if (!prenom) erreurs.push("Le prénom est obligatoire");
        //         if (!dateNaissance) erreurs.push("La date de naissance est obligatoire");
        //         if (!civilite) erreurs.push("La civilité est obligatoire");

        //         if (erreurs.length > 0) {
        //             swal.fire("Erreur", erreurs.join('\n'), "error");
        //             return;
        //         }

        //         // Validation de l'âge
        //         const assureActuel = assures[assureEnModification];
        //         if (dateNaissance && !validerAge(dateNaissance, assureActuel.lienParente)) {
        //             let message = "Âge non valide pour ce type d'assuré. ";
        //             switch(assureActuel.lienParente) {
        //                 case 'Conjoint':
        //                     message += "Le conjoint doit avoir entre 18 et 64 ans";
        //                     break;
        //                 case 'Enfant':
        //                     message += "L'enfant doit avoir entre 3 et 24 ans";
        //                     break;
        //                 case 'Autre':
        //                     message += "L'assuré doit avoir entre 18 et 70 ans";
        //                     break;
        //             }
        //             swal.fire("Erreur", message, "error");
        //             return;
        //         }

        //         // Mettre à jour l'assuré
        //         assures[assureEnModification] = {
        //             ...assures[assureEnModification],
        //             nom: nom,
        //             prenom: prenom,
        //             civilite: civilite,
        //             datenaissance: dateNaissance,
        //             mobileAssur: form.querySelector('[name="mobileAssurEdit"]')?.value || ''
        //         };

        //         sessionStorage.setItem("assures", JSON.stringify(assures));
        //         document.getElementById('assuresInput').value = JSON.stringify(assures);

        //         afficherAssures();
        //         afficherResumeAssures();

        //         // Fermer le modal
        //         const modalEdit = document.getElementById('modalAssurEditGeneric');
        //         if (modalEdit) {
        //             const bootstrapModal = bootstrap.Modal.getInstance(modalEdit);
        //             bootstrapModal.hide();
        //             modalEdit.remove();
        //         }

        //         assureEnModification = null;
        //         swal.fire("Succès", "Assuré modifié avec succès", "success");

        //     } catch (error) {
        //         console.error("Erreur lors de la modification:", error);
        //         swal.fire("Erreur", error.message, "error");
        //     }
        // }

        function sauvegarderModification() {
            try {
                if (assureEnModification === null) {
                    throw new Error("Aucun assuré en cours de modification");
                }

                const form = document.querySelector('#AssurEditModalForm');
                if (!form) {
                    throw new Error("Formulaire de modification non trouvé");
                }

                // Validation des champs obligatoires pour l'édition
                const nom = form.querySelector('[name="nomAssurEdit"]')?.value?.trim() || '';
                const prenom = form.querySelector('[name="prenomAssurEdit"]')?.value?.trim() || '';
                const dateNaissance = form.querySelector('[name="datenaissanceAssurEdit"]')?.value || '';
                const civilite = form.querySelector('input[name="civiliteAssurEdit"]:checked')?.value || '';
                const numeropiece = form.querySelector('[name="numeropieceAssurEdit"]')?.value?.trim() || '';

                const erreurs = [];
                if (!nom) erreurs.push("Le nom est obligatoire");
                if (!prenom) erreurs.push("Le prénom est obligatoire");
                if (!dateNaissance) erreurs.push("La date de naissance est obligatoire");
                if (!civilite) erreurs.push("La civilité est obligatoire");
                if (!numeropiece) erreurs.push("Le numéro de pièce est obligatoire");

                if (erreurs.length > 0) {
                    swal.fire("Erreur", erreurs.join('\n'), "error");
                    return;
                }

                // Validation de l'âge
                const lienParente = form.querySelector('[name="lienParenteAssurEdit"]')?.value || assures[assureEnModification].lienParente;
                if (dateNaissance && !validerAge(dateNaissance, lienParente)) {
                    let message = "Âge non valide pour ce type d'assuré. ";
                    switch(lienParente) {
                        case 'Conjoint':
                            message += "Le conjoint doit avoir entre 18 et 64 ans";
                            break;
                        case 'Enfant':
                            message += "L'enfant doit avoir entre 3 et 24 ans";
                            break;
                        case 'Autre':
                            message += "L'assuré doit avoir entre 18 et 70 ans";
                            break;
                    }
                    swal.fire("Erreur", message, "error");
                    return;
                }

                // Mettre à jour l'assuré
                assures[assureEnModification] = {
                    ...assures[assureEnModification],
                    nom: nom,
                    prenom: prenom,
                    civilite: civilite,
                    datenaissance: dateNaissance,
                    mobileAssur: form.querySelector('[name="mobileAssurEdit"]')?.value || '',
                    lienParente: lienParente,
                    filiation: form.querySelector('[name="filiationAssurEdit"]')?.value || '',
                    naturepieceAssur: form.querySelector('[name="naturepieceAssurEdit"]')?.value || '',
                    numeropieceAssur: numeropiece
                };

                sessionStorage.setItem("assures", JSON.stringify(assures));
                document.getElementById('assuresInput').value = JSON.stringify(assures);

                afficherAssures();
                afficherResumeAssures();

                // Fermer le modal
                const modalEdit = document.getElementById('modalAssurEditGeneric');
                if (modalEdit) {
                    const bootstrapModal = bootstrap.Modal.getInstance(modalEdit);
                    bootstrapModal.hide();
                    modalEdit.remove();
                }

                assureEnModification = null;
                swal.fire("Succès", "Assuré modifié avec succès", "success");

            } catch (error) {
                console.error("Erreur lors de la modification:", error);
                swal.fire("Erreur", error.message, "error");
            }
        }

        // Fonction pour afficher les assurés dans le tableau principal
        function afficherAssures() {
            const tbody = document.querySelector('#test-l-2 tbody');
            if (!tbody) return;

            tbody.innerHTML = '';
            
            assures.forEach((assure, index) => {
                const row = document.createElement('tr');
                
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
                        <a href="#" class="text-primary me-2" onclick="event.preventDefault(); modifierAssure(${index})" title="Modifier">
                            <i class="fadeIn animated bx bx-edit fs-4"></i>
                        </a>
                        <a href="#" class="text-danger" onclick="event.preventDefault(); supprimerAssure(${index})" title="Supprimer">
                            <i class="fadeIn animated bx bx-x fs-4"></i>
                        </a>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        // Fonction pour afficher le résumé des assurés
        function afficherResumeAssures() {
            const tbodyResume = document.getElementById('resumAssur');
            if (!tbodyResume) return;

            tbodyResume.innerHTML = '';

            assures.forEach(assure => {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td>${assure.nom}</td>
                    <td>${assure.prenom}</td>
                    <td>${assure.datenaissance || ''}</td>
                    <td>${assure.lieuNaissance || ''}</td>
                    <td>${assure.lieuresidenceAssur || ''}</td>
                    <td>${assure.filiation || ''}</td>
                    <td>
                        <ul>
                            ${assure.garanties?.map(g => `<li>${g.MonLibelle}</li>`).join('') || '<li>Pas de garantie</li>'}
                        </ul>
                    </td>
                    <td>${assure.mobileAssur || ''}</td>
                    <td>${assure.emailAssur || ''}</td>
                    <td>${assure.naturepieceAssur || ''}</td>
                `;
                
                tbodyResume.appendChild(row);
            });
        }

        // Fonction pour supprimer un assuré
        function supprimerAssure(index) {
            swal.fire({
                title: 'Confirmation',
                text: "Voulez-vous vraiment supprimer cet assuré ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    assures.splice(index, 1);
                    sessionStorage.setItem("assures", JSON.stringify(assures));
                    document.getElementById('assuresInput').value = JSON.stringify(assures);
                    afficherAssures();
                    afficherResumeAssures();
                    swal.fire('Supprimé!', 'L\'assuré a été supprimé.', 'success');
                }
            });
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
                    garanties: getGarantiesByLienParente('Adherent'),
                    civilite: '',
                    datenaissance: '',
                    lieuNaissance: '',
                    lieuresidenceAssur: '',
                    filiation: '',
                    mobileAssur: '',
                    emailAssur: '',
                    naturepieceAssur: '',
                    numeropieceAssur: ''
                });
                sessionStorage.setItem("assures", JSON.stringify(assures));
            }

            afficherAssures();
            afficherResumeAssures();
            
            // Gestion du bouton d'ajout
            const btnAjouter = document.querySelector('#createPropositionModal .btn-primary');
            if (btnAjouter) {
                btnAjouter.addEventListener('click', ajouterAssureTemporaire);
            }

            // Désactiver les options de lien de parenté selon les règles
            const selectLienParente = document.querySelector('[name="lienParente"]');
            if (selectLienParente) {
                selectLienParente.addEventListener('change', function() {
                    const optionConjoint = this.querySelector('option[value="Conjoint"]');
                    const optionEnfant = this.querySelector('option[value="Enfant"]');
                    
                    if (optionConjoint) {
                        optionConjoint.disabled = conjointExisteDeja();
                    }
                    
                    if (optionEnfant) {
                        optionEnfant.disabled = nombreEnfants() >= 4;
                    }
                });
            }
        }

        // Exposer les fonctions globales
        window.ajouterAssureTemporaire = ajouterAssureTemporaire;
        window.supprimerAssure = supprimerAssure;
        window.modifierAssure = modifierAssure;
        window.sauvegarderModification = sauvegarderModification;

        // Démarrer
        init();
    });
</script>
