<!-- Modal -->
<div class="modal fade" id="modalAssurEdit${ $assure->id }" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier un Assuré</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        {{-- {{ $product->MonLibelle }} --}}
                    </div>
                    <div class="card-body">
                        <form action="" method="" id="AssurEditModal">
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-lg-6">
                                    <label for="nomAssur" class="form-label">Nom de l'assuré <span class="star">*</span></label>
                                    <input type="text" name="nomAssur" class="form-control" id="nomAssur"
                                        placeholder="Nom" autocomplete="off">
                                    @error('nomAssur')
                                        <span class="text-danger"> Veuillez remplir le champ nom</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="prenomAssur" class="form-label">Prénoms de l'assuré <span class="star">*</span></label>
                                    <input type="text" name="prenomAssur" class="form-control" id="prenomAssur"
                                        placeholder="Prénoms">
                                    @error('prenomAssur')
                                        <span class="text-danger"> Veuillez remplir le champ prenom </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button" class="btn border-btn px-4" data-bs-dismiss="modal">Retour</button>
                                    <button type="button" class="btn btn-two px-4" id="btn-edit" onclick="editAssureTemporaire()">Modifier</button>
                                </div>
                                
                            </div> 
                        </form> 
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>