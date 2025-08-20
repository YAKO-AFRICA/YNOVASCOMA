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
                        <a href="#" class="text-danger" onclick="event.preventDefault(); supprimerAssure(${index})">
                            <i class="fadeIn animated bx bx-x fs-4"></i>
                        </a>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
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

        // Démarrer
        init();
    });
</script> --}}

<script>
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

        function updatePrimeTotale() {
            const primeTotale = PRIME_BASE + FRAIS_ADHESION;
            document.getElementById('prime-base').textContent = formatNumber(PRIME_BASE);
            document.getElementById('frais-adhesion').textContent = formatNumber(FRAIS_ADHESION);
            document.getElementById('prime-totale').textContent = formatNumber(primeTotale);
            
            sessionStorage.setItem('primeDetails', JSON.stringify({
                primeBase: PRIME_BASE,
                fraisAdhesion: FRAIS_ADHESION,
                primeTotale: primeTotale
            }));
        }

        // Fonction pour ajouter un assuré
        function ajouterAssureTemporaire() {
            try {
                const form = document.querySelector('#createPropositionModal form');
                if (!form) throw new Error("Formulaire non trouvé");
                
                const nouvelAssure = {
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
                
                // Validation des champs obligatoires
                if (!nouvelAssure.nom || !nouvelAssure.prenom || !nouvelAssure.civilite || !nouvelAssure.lienParente) {
                    throw new Error("Veuillez remplir tous les champs obligatoires");
                }
                
                assures.push(nouvelAssure);
                sessionStorage.setItem("assures", JSON.stringify(assures));

                document.getElementById('assuresInput').value = JSON.stringify(assures);
                
                afficherAssures();
                afficherResumeAssures();
                updatePrimeTotale();
                
                
                // if (modal) modal.hide();
                const bootstrapModal = bootstrap.Modal.getInstance(modalElement);
                form.reset();
                bootstrapModal.hide();
            } catch (error) {
                console.error("Erreur lors de l'ajout d'un assuré:", error);
                // alert(error.message);
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
                updatePrimeTotale();
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
            updatePrimeTotale();
            
            // Gestion du bouton d'ajout
            const btnAjouter = document.querySelector('#createPropositionModal .btn-primary');
            if (btnAjouter) {
                btnAjouter.addEventListener('click', ajouterAssureTemporaire);
            }
        }

        // Exposer les fonctions globales
        window.ajouterAssureTemporaire = ajouterAssureTemporaire;
        window.supprimerAssure = supprimerAssure;

        // Démarrer
        init();
    });
</script>

  // Fonction pour calculer l'âge à partir d'une date de naissance
        function calculateAge(dateNaissance) {
            if (!dateNaissance) return 0;
            
            const today = new Date();
            const birthDate = new Date(dateNaissance);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            // Si le mois de naissance n'est pas encore passé ou si c'est le mois mais que le jour n'est pas encore passé
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            return age;
        }

        // Récupérer les valeurs
                const dateNaissance = form.querySelector('[name="datenaissanceAssur"]')?.value;
                const filiation = form.querySelector('[name="filiation"]')?.value;
                const lienParente = form.querySelector('[name="lienParente"]')?.value;
                
                // Validation de l'âge en fonction de la filiation
                if (dateNaissance) {
                    const age = calculateAge(dateNaissance);
                    
                    if (filiation === 'Enfant' || lienParente === 'Enfant') {
                        // Validation pour les enfants (3-24 ans)
                        if (age < 3 || age > 24) {
                            throw new Error("Un enfant doit avoir entre 3 et 24 ans");
                        }
                    } else {
                        // Validation pour les adultes (18-70 ans)
                        if (age < 18 || age > 70) {
                            throw new Error("L'assuré doit avoir entre 18 et 70 ans");
                        }
                    }
                } else {
                    throw new Error("La date de naissance est obligatoire");
                }
                
