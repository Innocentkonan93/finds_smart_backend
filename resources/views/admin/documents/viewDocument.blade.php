@extends('admin.layout.layout')
@php
    $title='Voir le document';
    $subTitle = 'Voir le document';
    $script = '<script>
                    // ======================== Image Upload Start =====================
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById("imagePreview").style.backgroundImage = "url(" + e.target.result + ")";
                                document.getElementById("imagePreview").style.display = "none";
                                $("#imagePreview").fadeIn(650);
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    document.getElementById("imageUpload").addEventListener("change", function() {
                        readURL(this);
                    });
                    // ======================== Image Upload End =====================

                    // ================== Toggle Password Visibility Start ==========
                    function initializePasswordToggle(toggleSelector) {
                        document.querySelectorAll(toggleSelector).forEach(function(toggle) {
                            toggle.addEventListener("click", function() {
                                this.classList.toggle("ri-eye-off-line");
                                var input = document.querySelector(this.getAttribute("data-toggle"));
                                if (input.getAttribute("type") === "password") {
                                    input.setAttribute("type", "text");
                                } else {
                                    input.setAttribute("type", "password");
                                }
                            });
                        });
                    }
                    // Call the function
                    initializePasswordToggle(".toggle-password");
                    // ========================= Toggle Password Visibility End ===========================

                    // Auto hide alerts after 5 seconds
                    document.addEventListener("DOMContentLoaded", function() {
                        setTimeout(function() {
                            var alerts = document.querySelectorAll(".alert");
                            alerts.forEach(function(alert) {
                                var bsAlert = new bootstrap.Alert(alert);
                                bsAlert.close();
                            });
                        }, 5000);
                    });

                    let table = new DataTable("#dataTable");
                    let table2 = new DataTable("#dataTable2");
            </script>';
@endphp

@section('content')

            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                        <div class="custom-bg"  style="height: 120px;"  ></div>
                        {{-- <img src="{{ asset('assets/images/user-grid/user-grid-bg1.png') }}" alt="" class="w-100 object-fit-cover"> --}}
                        
                        <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                            <div class="text-center border border-top-0 border-start-0 border-end-0">
                                <img src="{{ $document->file_path ? Storage::url($document->file_path) : asset('assets/images/user-grid/user-grid-img' . ($loop->index % 12 + 1) . '.png') }}" alt="" class="border br-white border-width-2-px w-300-px h-150-px radius-8 object-fit-cover">
                                <h6 class="mb-0 mt-16">{{ $document->type }}</h6>

                            </div>
                            <div class="mt-24">
                                <h6 class="text-xl mb-16">Informations du document</h6>
                                <ul>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Type</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $document->type }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light"> Utilisateur</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $document->user->name }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light"> Statut</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $document->is_validated == 1 ? 'Validé' : 'Non validé' }}</span>
                                    </li>
                                     
                                </ul>
                                <p class="text-secondary-light mt-24"> Modifié le: {{ \Carbon\Carbon::parse($document->updated_at)->format('d M Y') }}</p>
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
                                        Modifier le document
                                    </button>
                                </li>
                            </ul>
                            <form action="{{ route('updateDocument', $document->id) }}" method="POST" enctype="multipart/form-data">
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

                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab" tabindex="0">
                                   
                                    
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-20">
                                                        <label for="amount" class="form-label fw-semibold text-primary-light text-sm mb-8"> Type </label>
                                                        <input type="text" readonly name="type" class="form-control radius-8" id="type" placeholder="Entrez le type" value="{{ $document->type }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb-20">
                                                        <label for="status" class="form-label fw-semibold text-primary-light text-sm mb-8">Status</label>
                                                        <select name="is_validated" class="form-control radius-8" id="is_validated">
                                                            <option value="1" {{ $document->is_validated == 1 ? 'selected' : '' }}>Validé</option>
                                                            <option value="0" {{ $document->is_validated == 0 ? 'selected' : '' }}>Non validé</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="mb-20">
                                                        <label for="status" class="form-label fw-semibold text-primary-light text-sm mb-8">Utilisé</label>
                                                        
                                                        <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                                            <input class="form-check-input" name="is_validated" type="checkbox" role="switch" id="is_validated" {{ $document->is_validated == 1 ? 'checked' : '' }} disabled>
                                                            <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="is_validated">{{ $document->is_validated == 1 ? 'Oui' : 'Non' }}  </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center gap-3">
                                                <a href="{{ route('documentsList') }}" class="btn btn-secondary border border-secondary-600 text-md px-56 py-12 radius-8">
                                                    Retour
                                                </a>
                                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                                    Enregistrer
                                                </button>
                                            </div>
                                    </div>
                                     
                                </div>
                            </form>
                        </div>
                    </div>
                </div>                 
            </div>

@endsection
