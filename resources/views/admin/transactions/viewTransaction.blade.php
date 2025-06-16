@extends('admin.layout.layout')
@php
    $title='Voir la transaction';
    $subTitle = 'Voir la transaction';
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
                    <h6 class="text-xl mb-16">Informations de la transaction</h6>
                    <ul>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Référence</span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $transaction->reference }}</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Montant </span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ number_format($transaction->amount, 0, ',', ' ') }} FCFA</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Canal </span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $transaction->channel }}</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Statut </span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $transaction->status }}</span>
                        </li>
                        <li class="d-flex align-items-center gap-1 mb-12">
                            <span class="w-30 text-md fw-semibold text-primary-light"> Client </span>
                            <span class="w-70 text-secondary-light fw-medium">: {{ $transaction->user->name }}</span>
                        </li>
                    </ul>
                    <p class="text-secondary-light mt-24"> Créé le: {{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y') }}</p>
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
                            Détails de la transaction
                        </button>
                    </li>
                     
                </ul>
                    <form action="{{ route('updateTransaction', $transaction->id) }}" method="POST" enctype="multipart/form-data">
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
                                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8"> Référence de la transaction </label>
                                            <input readonly type="text" name="reference" class="form-control radius-8" id="reference" placeholder="Entrez la référence de la transaction" value="{{ $transaction->reference }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8"> Montant de la transaction </label>
                                            <input readonly type="number" name="amount" class="form-control radius-8" id="amount" placeholder="Entrez le montant de la transaction" value="{{ $transaction->amount }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8"> Canal de la transaction </label>
                                            <input readonly type="text" name="channel" class="form-control radius-8" id="channel" placeholder="Entrez le canal de la transaction" value="{{ $transaction->channel }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8"> Statut de la transaction </label>
                                            <input readonly type="text" name="status" class="form-control radius-8" id="status" placeholder="Entrez le statut de la transaction" value="{{ $transaction->status }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8"> Client </label>
                                            <input readonly type="text" name="user_id" class="form-control radius-8" id="user_id" placeholder="Entrez le client" value="{{ $transaction->user->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <a href="{{ route('ordersList') }}" class="btn btn-secondary border border-secondary-600 text-md px-56 py-12 radius-8">
                                        Retour
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
