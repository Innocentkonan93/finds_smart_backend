@extends('admin.layout.layout')
@php
    $title='View Metier';
    $subTitle = 'View Metier';
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
                    <h6 class="text-xl mb-16">Informations du metier</h6>
                    <ul>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light">Nom du metier</span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $job->name }}</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Description</span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $job->description }}</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Code couleur</span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $job->color }}</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Status</span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $job->is_active == 1 ? 'Actif' : 'Inactif' }}</span>
                        </li>
                    </ul>

                    <p class="text-secondary-light mt-24"> Créé le: {{ \Carbon\Carbon::parse($job->created_at)->format('d M Y') }}</p>
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
                            Modifier le metier
                        </button>
                    </li>

                </ul>
                <form action="{{ route('updateJob', $job->id) }}" method="POST" enctype="multipart/form-data">
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
                                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8"> Nom du metier <span class="text-danger-600">*</span></label>
                                            <input type="text" name="name" class="form-control radius-8" id="name" placeholder="Entrez le nom du metier" value="{{ $job->name }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="description" class="form-label fw-semibold text-primary-light text-sm mb-8">Description <span class="text-danger-600">*</span></label>
                                            <textarea type="text" name="description" class="form-control radius-8" rows="1" id="description" placeholder="Entrez la description du metier">{{ $job->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="color" class="form-label fw-semibold text-primary-light text-sm mb-8">Code couleur</label>
                                            <input type="text" name="color" class="form-control radius-8" id="color" placeholder="Entrez le code couleur" value="{{ $job->color }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="depart" class="form-label fw-semibold text-primary-light text-sm mb-8">Statut <span class="text-danger-600">*</span> </label>
                                            <select class="form-control radius-8 form-select" id="status" name="status" value="{{ $job->is_active }}"  >
                                                <option value="1" {{ $job->is_active == 1 ? 'selected' : '' }}>Actif</option>
                                                <option value="0" {{ $job->is_active == 0 ? 'selected' : '' }}>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <a href="{{ route('jobsList') }}" class="btn btn-secondary border border-secondary-600 text-md px-56 py-12 radius-8">
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
