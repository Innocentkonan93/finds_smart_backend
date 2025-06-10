@extends('admin.layout.layout')
@php
    $title='Voir l\'annonce';
    $subTitle = 'Voir l\'annonce';
    $script ='<script>
                    // ======================== Upload Image Start =====================
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $("#imagePreview").css("background-image", "url(" + e.target.result + ")");
                                $("#imagePreview").hide();
                                $("#imagePreview").fadeIn(650);
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("#imageUpload").change(function() {
                        readURL(this);
                    });
                    // ======================== Upload Image End =====================

                    // ================== Password Show Hide Js Start ==========
                    function initializePasswordToggle(toggleSelector) {
                        $(toggleSelector).on("click", function() {
                            $(this).toggleClass("ri-eye-off-line");
                            var input = $($(this).attr("data-toggle"));
                            if (input.attr("type") === "password") {
                                input.attr("type", "text");
                            } else {
                                input.attr("type", "password");
                            }
                        });
                    }
                    // Call the function
                    initializePasswordToggle(".toggle-password");
                    // ========================= Password Show Hide Js End ===========================
            </script>';
@endphp

@section('content')

<div class="row gy-4">
    <div class="col-lg-4">
        <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
            <div class="custom-bg"  style="height: 120px;"  ></div>
            {{-- <img src="{{ asset('assets/images/user-grid/user-grid-bg1.png') }}" alt="" class="w-100 object-fit-cover"> --}}
            
            <div class="pb-24 ms-16 mb-24 me-16  mt--100">
         
                <div class="mt-24">
                    <h6 class="text-xl mb-16">Informations de l'annonce</h6>
                    <ul>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light">Titre</span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $ad->title }}</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Description</span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $ad->description }}</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Budget</span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ number_format($ad->budget, 0, ',', ' ') }} FCFA</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Date de début</span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $ad->start_date ? \Carbon\Carbon::parse($ad->start_date)->format('d M Y') : '' }}</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Ville</span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $ad->city }}</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> District</span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $ad->district }}</span>
                        </li> 
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Statut</span>
                            @switch($ad->status)
                            @case('pending')
                                <span class="bg-warning-focus text-warning-600 border border-warning-main px-24 py-4 radius-4 fw-medium text-sm">En attente</span>
                                @break
                            @case('accepted') 
                                <span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Acceptée</span>
                                @break
                            @case('completed')
                                <span class="bg-info-focus text-info-600 border border-info-main px-24 py-4 radius-4 fw-medium text-sm">Terminée</span>
                                @break
                            @case('cancelled')
                                <span class="bg-danger-focus text-danger-600 border border-danger-main px-24 py-4 radius-4 fw-medium text-sm">Annulée</span>
                                @break
                            @default
                                <span class="bg-neutral-focus text-neutral-600 border border-neutral-main px-24 py-4 radius-4 fw-medium text-sm">{{ $ad->status }}</span>
                        @endswitch
                        </li>
                        
                    </ul>

                    <p class="text-secondary-light mt-24"> Créé le: {{ \Carbon\Carbon::parse($ad->created_at)->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-body p-24">
                <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center px-24 active" id="pills-edit-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-edit-profile" type="button" role="tab" aria-controls="pills-edit-profile" aria-selected="true">
                            Modifier le profil
                        </button>
                    </li>
                     
                </ul>
                <form action="{{ route('updateAd', $ad->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                    <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-5 fw-semibold text-lg radius-12 d-flex align-items-center justify-content-between" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif --}}
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8"> Titre de l'annonce <span class="text-danger-600">*</span></label>
                                            <input type="text" name="name" class="form-control radius-8" id="name" placeholder="Entrez le titre de l'annonce" value="{{ $ad->title }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">Description <span class="text-danger-600">*</span></label>
                                            <textarea type="text" name="description" rows="1" class="form-control radius-8" id="description" placeholder="Entrez la description" value="{{ $ad->description }}">{{ $ad->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Budget</label>
                                            <input type="number" name="budget" class="form-control radius-8" id="number" placeholder="Entrez le budget" value="{{ $ad->budget }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Date de début</label>
                                            <input type="date" name="start_date" class="form-control radius-8" id="start_date" placeholder="Entrez la date de début" value="{{ old('start_date', $ad->start_date ? \Carbon\Carbon::parse($ad->start_date)->format('Y-m-d') : '') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Ville</label>
                                            <input type="text" name="city" class="form-control radius-8" id="number" placeholder="Entrez la ville" value="{{ $ad->city }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">District</label>
                                            <input type="text" name="district" class="form-control radius-8" id="number" placeholder="Entrez le district" value="{{ $ad->district }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="desig" class="form-label fw-semibold text-primary-light text-sm mb-8">Statut <span class="text-danger-600">*</span> </label>
                                            <select class="form-control radius-8 form-select" id="status" name="status">
                                                <option value="pending" {{ $ad->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                                <option value="accepted" {{ $ad->status == 'accepted' ? 'selected' : '' }}>Accepté</option>
                                                <option value="cancelled" {{ $ad->status == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                            </select>

                                            {{-- <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                                <label for="companzNew" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                                <div class="d-flex align-items-center gap-3 justify-content-between">
                                                    <span class="form-check-label line-height-1 fw-medium text-secondary-light">{{ $user->is_active == 1 ? 'Désactiver' : 'Activer' }}</span>
                                                    <input class="form-check-input" type="checkbox" role="switch" id="companzNew">
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <a href="{{ route('adsList') }}" class="btn btn-secondary border border-secondary-600 text-md px-56 py-12 radius-8">
                                        Retour
                                    </a>
                                    <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
