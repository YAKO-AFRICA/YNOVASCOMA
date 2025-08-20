@extends('layouts.main')

@section('content')


<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"><a href="/shared/home"><i class="bx bx-home-alt"></i></a></div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Rapport</li>
                    <li class="breadcrumb-item active" aria-current="page">Demande de pret</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Reglages</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                    <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#columnsModalPart">Personnaliser les colonnes</a>
                </div>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card p-3">
        <form id="searchForm" class="row g-3" method="GET" action="{{ route('report.ePret') }}">

            <fieldset class="col-md-6">
                <legend class="float-none w-auto px-2">Recherche par Date</legend>
        
                <div class="row">
                    <div class="col-md-6">
                        <label for="dateFrom" class="form-label">Date de Saisie (De)</label>
                        <input type="date" class="form-control" id="dateFrom" name="dateFrom" value="{{ request('dateFrom') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="dateTo" class="form-label">Date de Saisie (À)</label>
                        <input type="date" class="form-control" id="dateTo" name="dateTo" value="{{ request('dateTo') }}">
                    </div>
                </div>
            </fieldset>

            <fieldset class="col-md-3">
                <legend class="float-none w-auto px-2">Recherche par Agent</legend>
                
                <select name="agent" id="agent" class="form-select">
                    <option value="">-- Choisir une option --</option>
                    @foreach ($agents as $item)
                        <option value="{{ $item->idmembre }}" {{ request('agent') == $item->idmembre ? 'selected' : '' }}>
                            {{ $item->nom }} {{ $item->prenom }}
                        </option>
                    @endforeach
                </select>
            </fieldset>
        
            <fieldset class="col-md-3">
                <legend class="float-none w-auto px-2">Recherche par Etape</legend>
                <select class="form-select" id="searchEtape" name="etape">
                    <option value="">Choisir un statut</option>
                    <option value="1" {{ request('etape') == '1' ? 'selected' : '' }}>En saisie</option>
                    <option value="2" {{ request('etape') == '2' ? 'selected' : '' }}>Transmis</option>
                    <option value="3" {{ request('etape') == '3' ? 'selected' : '' }}>Accepté</option>
                    <option value="4" {{ request('etape') == '4' ? 'selected' : '' }}>Rejeté</option>
                </select>
            </fieldset>
        
            <div class="col">
                <button type="submit" class="btn btn-primary btn-lg float-right">Rechercher</button>
            </div>
        </form>
        
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
    
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Demandes</p>
                            <h4 class="my-1">{{ count($prets) }}</h4>
                        </div>
                        <div class="text-warning ms-auto font-35"><i class='bx bxl-github'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Transmis</p>
                            <h4 class="my-1">{{ count($prets->where('etat', '2')) }}</h4>
                        </div>
                        <div class="text-info ms-auto font-35"><i class='bx bxl-firefox'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Accepter</p>
                            <h4 class="my-1">{{ count($prets->where('etat', '3')) }}</h4>
                        </div>
                        <div class="text-success ms-auto font-35"><i class='bx bxl-shopify'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Rejeté</p>
                            <h4 class="my-1">{{ count($prets->where('etat', '4')) }}</h4>
                        </div>
                        <div class="text-danger ms-auto font-35"><i class='bx bxl-chrome'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">

            <!-- Tableau -->
            <table class="table mb-0" id="example2">
                <thead class="table-light">
                    <tr>
                        @foreach ($defaultColumns as $defaultColumn)
                            <th>{{ $defaultColumn }}</th>
                        @endforeach

                        @foreach ($activeColumns as $colKey)
                            <th>{{ array_search($colKey, $additionalColumns) }}</th>
                        @endforeach
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prets as $item)
                    <tr class="">
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->typepret ?? "" }}</td>
                        <td>{{ $item->effetgarantie ?? "" }}</td>
                        <td>{{ $item->prime + $item->primeobseque + $item->primeemprunteur + $item->surprime ?? "" }}</td>

                        <td>{{ $item->montantpret ?? "" }}</td>
                        <td>{{ $item->user->membre->nom ?? "" }} {{ $item->user->membre->prenom ?? "" }}</td>
                        <td>
                            @if ($item->etat == '0')
                                <div class="badge rounded-pill text-secondary bg-light-secondary p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Saisie non achevée</div>
                            @elseif ($item->etat == '1')
                                <div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Saisie Non Transmis</div>
                            @elseif ($item->etat == '2')
                                <div class="badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Transmis</div>
                            @elseif ($item->etat == '3')
                                <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Accepté</div>
                            @elseif ($item->etat == '4')
                                <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Rejeté</div>
                            @endif
                        </td>
                        
                        @foreach ($activeColumns as $colKey)
                            <td>{{ $item->$colKey ?? '' }}</td>
                        @endforeach
                        <td>
                            <div class="d-flex order-actions">
                                <a href="{{ route('prod.show', $item->id)}}">
                                    <i class='bx bxs-show'></i>
                                </a>
                                
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($defaultColumns) + count($activeColumns) + 1 }}">Aucun contrat trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Modal de personnalisation des colonnes -->
            <div class="modal fade" id="columnsModalPart" tabindex="-1" aria-labelledby="columnsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('setting.updateColumnsPart') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="columnsModalLabel">Personnaliser les colonnes</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @foreach ($additionalColumns as $label => $key)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="columns[]" value="{{ $key }}"
                                            id="col-{{ $key }}" 
                                            {{ in_array($key, $activeColumns) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="col-{{ $key }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                            </div>
                        </form>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection