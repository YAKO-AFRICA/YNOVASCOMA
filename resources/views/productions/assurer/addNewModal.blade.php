<!-- Modal -->

<div class="modal fade" id="addAssureModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Ajouter un Assuré</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body">

                <div class="card">

                    <div class="card-header">

                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('prod.store.assurer') }}"  class="submitForm">

                            @csrf

                            <fieldset class="border p-3">

                                <legend class="float-none w-auto px-2"><small>Information personnelle</small></legend>

                                <div class="col-12 col-lg-6">

                                    <label for="civiliteAssur" class="form-label">Civilité <span class="text-danger">*</span></label>

                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" type="radio" name="civiliteAssur" id="inlineRadio1" value="Madame" autocomplete="off" required>

                                        <label class="form-check-label" for="inlineRadio1">Madame</label>

                                    </div>

                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" type="radio" name="civiliteAssur" id="inlineRadio2" value="Mademoiselle" autocomplete="off">

                                        <label class="form-check-label" for="inlineRadio2">Mademoiselle</label>

                                    </div>

                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" type="radio" name="civiliteAssur" id="inlineRadio3" value="Monsieur" autocomplete="off">

                                        <label class="form-check-label" for="inlineRadio3">Monsieur</label>

                                    </div>

                                    @error('civiliteAssur')

                                        <span class="text-danger"> Veuillez remplir le champ nom</span>

                                    @enderror

                                </div>

                                <div class="row g-3 mb-3">

                                    <div class="col-12 col-lg-6">

                                        <label for="nomAssur" class="form-label">Nom de l'assuré <span class="text-danger">*</span></label>

                                        <input type="text" name="nomAssur" class="form-control" id="nomAssur"

                                            placeholder="Nom" autocomplete="off" required>

                                        @error('nomAssur')

                                            <span class="text-danger"> Veuillez remplir le champ nom</span>

                                        @enderror

                                    </div>

                                    <div class="col-12 col-lg-6">

                                        <label for="prenomAssur" class="form-label">Prénoms de l'assuré <span class="text-danger">*</span></label>

                                        <input type="text" name="prenomAssur" class="form-control" id="prenomAssur"

                                            placeholder="Prénoms" required>

                                        @error('prenomAssur')

                                            <span class="text-danger"> Veuillez remplir le champ prenom </span>

                                        @enderror

                                    </div>

                                </div><!---end row-->

                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-lg-6">
                                        <label for="datenaissanceAssur" class="form-label">Date de naissance <span class="text-danger">*</span></label>
                                        <input type="date" name="datenaissanceAssur" class="form-control" id="datenaissanceAssur"
                                            placeholder="Date de naissance" required>
                                        @error('datenaissanceAssur')
                                            <span class="text-danger"> Veuillez remplir la date de naissance </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-lg-6"> 
                                        <label for="lieunaissanceAssur" class="form-label">Lieu de naissance</label>
                                        <select class="form-select" name="lieunaissanceAssur" id="lieunaissanceAssur" data-placeholder="Sélectionner le lieu">
                                            <option value="">Sélectionner le lieu</option> <!-- Option vide pour le placeholder -->
                                            @foreach($villes as $ville)
                                                <option value="{{ $ville->libelleVillle }}">{{ $ville->libelleVillle }}</option> 
                                            @endforeach 
                                        </select>
                                    </div>
                                </div><!---end row-->

                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-lg-6">
                                        <label for="" class="form-label">Nature de la pièce</label>
                                        <br> 
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="naturepieceAssur" id="CNIAssur" value="CNI">
                                            <label class="form-check-label" for="CNIAssur">CNI</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="naturepieceAssur" id="AtestationAssur" value="AT">
                                            <label class="form-check-label" for="AtestationAssur">Atestation</label>

                                        </div>

                                        <div class="form-check form-check-inline">

                                            <input class="form-check-input" type="radio" name="naturepieceAssur" id="PassportAssur" value="Passport">

                                            <label class="form-check-label" for="PassportAssur">Passport</label>

                                        </div> 

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="naturepieceAssur" id="ExtraitAssur" value="Extrait">
                                            <label class="form-check-label" for="ExtraitAssur">Extrait de naissance</label>
                                        </div> 

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="naturepieceAssur" id="CarteConsulaireAssur" value="CarteConsulaire">
                                            <label class="form-check-label" for="CarteConsulaireAssur">Carte Consulaire</label>
                                        </div> 

                                    </div>

                                    <div class="col-12 col-lg-6"> 

                                        <label for="numeropieceAssur" class="form-label">numéro de la pièce</label>

                                        <input type="text" name="numeropieceAssur" class="form-control" id="numeropieceAssur" placeholder="numero de la pièce d'identité">

                                    </div> 

                                </div><!---end row-->

                                <div class="row g-3 mb-3">

                                    <div class="col-12 col-lg-6"> 

                                        <label for="lieuresidenceAssur" class="form-label">Lieu de residence </label>

                                        <select class="form-select" name="lieuresidenceAssur" id="lieuresidenceAssur" data-placeholder="Sélectionner le lieu">

                                            <option selected>Sélectionner le lieu</option>
                                            @foreach($villes as $ville)
                                                <option value="{{ $ville->libelleVillle }}">{{ $ville->libelleVillle }}</option> 
                                            @endforeach 
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-6">

                                        <label for="lienParente" class="form-label">Lien de Parenté</label>

                                        <select class="form-select" name="lienParente" id="lienParente"

                                            aria-label="Default select example">

                                            <option selected>Sélectionner le lien de Parenté</option>

                                            <option value="Conjoint">Conjoint</option>

                                            <option value="Enfant">Enfant</option>

                                            <option value="Autre">Autre</option> 

                                        </select>

                                    </div> 

                                </div>

                                <div class="row g-3 mb-3">

                                    <div class="col-12 col-lg-6">

                                        <label class="form-label">Telephone</label><br>

                                        <div class="input-group mb-3">

                                            <input type="text" name="mobileAssur" class="form-control" aria-label="Text input with select">

                                        </div>

                                        

                                        @error('mobileAssur') 

                                            <span class="text-danger"> Veuillez remplir votre numéro de mobile </span> 

                                        @enderror 

                                    </div>

                                    <div class="col-12 col-lg-6">

                                        <label for="emailAssur" class="form-label">Email</label>

                                        <input type="email" name="emailAssur" class="form-control" id="emailAssur"

                                            placeholder="Email">

                                            

                                        @error('email')

                                        

                                            <span class="text-danger"> Veuillez remplir votre email </span>

                                        

                                        @enderror

                                    </div> 

                                </div>

                                <input type="hidden" name="contrat" value="{{ $contrat->id }}">
                            </fieldset>

                            @if ($contrat->codeproduit === "LFFUN")
                            <fieldset class="border p-4 rounded-3 shadow-sm">
                                <legend class="float-none w-auto px-2 mb-3"><small><strong>État de santé de l'assuré</strong></small></legend>
                            
                                <div class="row g-3 mb-4">
                            
                                    <div class="col-12 col-lg-8">
                                        <label for="EtatSante" class="form-label">L'assuré déclare être en bon état de santé <span class="text-danger">*</span></label>
                                    </div>
                            
                                    <div class="col-12 col-lg-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="EtatSante" id="EtatAssurSain" value="Sain">
                                            <label class="form-check-label" for="EtatAssurSain">Sain</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="EtatSante" id="EtatAssurMalade" value="Malade">
                                            <label class="form-check-label" for="EtatAssurMalade">Malade</label>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-lg-4">
                                        <div class="card shadow-sm border-light">
                                            <div class="card-body">
                                                <label for="diabete" class="form-label"><strong>Diabète</strong></label>
                                                <div class="form-check">
                                                    <input type="radio" name="diabete" id="diabeteOui" value="true" class="form-check-input">
                                                    <label for="diabeteOui" class="form-check-label">Oui</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" name="diabete" id="diabeteNon" value="false" class="form-check-input">
                                                    <label for="diabeteNon" class="form-check-label">Non</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <div class="col-12 col-lg-3 ">
                                        <div class="card shadow-sm border-light">
                                            <div class="card-body">
                                                <label for="cancer" class="form-label"><strong>Cancer</strong></label>
                                                <div class="form-check">
                                                    <input type="radio" name="cancer" id="cancerOui" value="true" class="form-check-input">
                                                    <label for="cancerOui" class="form-check-label">Oui</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" name="cancer" id="cancerNon" value="false" class="form-check-input">
                                                    <label for="cancerNon" class="form-check-label">Non</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <div class="col-12 col-lg-4">
                                        <div class="card shadow-sm border-light">
                                            <div class="card-body">
                                                <label for="avc" class="form-label"><strong>AVC</strong></label>
                                                <div class="form-check">
                                                    <input type="radio" name="avc" id="avcOui" value="true" class="form-check-input">
                                                    <label for="avcOui" class="form-check-label">Oui</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" name="avc" id="avcNon" value="false" class="form-check-input">
                                                    <label for="avcNon" class="form-check-label">Non</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-lg-4">
                                        <div class="card shadow-sm border-light">
                                            <div class="card-body">
                                                <label for="tension" class="form-label"><strong>Hypertension</strong></label>
                                                <div class="form-check">
                                                    <input type="radio" name="hypertension" id="tensionOui" value="true" class="form-check-input">
                                                    <label for="tensionOui" class="form-check-label">Oui</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" name="hypertension" id="tensionNon" value="false" class="form-check-input">
                                                    <label for="tensionNon" class="form-check-label">Non</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <div class="col-12 col-lg-4">
                                        <div class="card shadow-sm border-light">
                                            <div class="card-body">
                                                <label for="renalInsuff" class="form-label"><strong>Insuffisance rénale</strong></label>
                                                <div class="form-check">
                                                    <input type="radio" name="insuffRenal" id="renalInsuffOui" value="true" class="form-check-input">
                                                    <label for="renalInsuffOui" class="form-check-label">Oui</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" name="insuffRenal" id="renalInsuffNon" value="false" class="form-check-input">
                                                    <label for="renalInsuffNon" class="form-check-label">Non</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </fieldset>
                            @endif
                            
                            <div class="col-12">

                                <div class="d-flex align-items-center gap-3">

                                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Retour</button>

                                    <button type="submit" class="btn btn-success px-4">Ajouter</button>

                                </div>

                                
                            </div> 

                        </form> 

                    </div>

                </div>

            </div> 

        </div>

    </div>

</div>