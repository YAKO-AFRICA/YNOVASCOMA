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
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                    <li class="breadcrumb-item active" aria-current="page">Agences</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <div class=""><a href="javascript:;" class="btn btn-primary radius-30 mt-2 mt-lg-0" data-bs-toggle="modal" data-bs-target="#addAgence"><i class="bx bxs-plus-square"></i>Ajouter une agence</a>
                </div>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
  
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">

                <!-- Tableau -->
                <table class="table mb-0" id="example2">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Code Agence</th>
                            <th>Libelle</th>
                            <th>Code Banque</th>
                            <th>Partenaire</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($agencesByPartner as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->codeAgnce ?? "" }}</td>
                            <td>{{ $item->libelle ?? "" }}</td>
                            <td>{{ $item->codeBanque ?? "" }}</td>
                            <td>{{ $item->codePartner ?? "" }}</td>

                            <td>
                                <div class="d-flex order-actions">
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#EditAgence{{ $item->id }}">
                                        <i class='bx bxs-edit'></i>
                                    </a>

                                    <a class="deleteConfirmation ms-3" data-uuid="{{$item->id}}"
                                        data-type="confirmation_redirect" data-placement="top"
                                        data-token="{{ csrf_token() }}"
                                        data-url="{{route('setting.destroyAgence',$item->id)}}"
                                        data-title="Vous êtes sur le point de supprimer {{$item->codeAgnce}} "
                                        data-id="{{$item->id}}" data-param="0"
                                        data-route="{{route('setting.destroyAgence',$item->id)}}"><i
                                            class='bx bxs-trash' style="cursor: pointer"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <div class="collapse col-8">Aucune agence</div>
                        @endforelse
                    </tbody>
                </table>

                
            </div>
        </div>
    </div>
    @include('settings.agences.addModal')

</div>
@endsection