@extends('admin.layout.layout')
@php
    $title='Liste des packs';
    $subTitle = 'Liste des packs';
    $script ='<script>
                        $(".remove-item-btn").on("click", function() {
                            $(this).closest("tr").addClass("d-none")
                        });

                         document.querySelectorAll(".add-kanban, .add-user-button").forEach(button => {
                    button.addEventListener("click", function() {
                        var addTaskModal = new bootstrap.Modal(document.getElementById("addTaskModal"));
                        // document.getElementById("editTaskId").value = ""; // Clear edit ID
                        // document.getElementById("taskTitle").value = ""; // Clear title
                        // document.getElementById("taskDescription").value = ""; // Clear description
                        // document.getElementById("taskTag").value = ""; // Clear Tag
                        // document.getElementById("startDate").value = ""; // Clear Date
                        // document.getElementById("taskImage").value = ""; // Clear file input
                        // document.getElementById("taskImagePreview").style.display = "none"; // Hide image preview
                        // document.getElementById("taskImagePreview").src = ""; // Clear image preview
                        addTaskModal.show();
                    });
                });

                    // Preview the image when a file is selected
                document.getElementById("taskImage").addEventListener("change", function() {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var imagePreview = document.getElementById("taskImagePreview");
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = "block";
                        imagePreview.style.height = "50px"; // Fix image height
                    };
                    if (file) {
                        reader.readAsDataURL(file);
                    }
                });

                // ================== Image Upload Js Start ===========================
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
                    // ================== Image Upload Js End ===========================
            </script>';
            
@endphp

@section('content')

            <div class="card h-100 p-0 radius-12">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        @if ($errors->any())
                        <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-5 fw-semibold text-lg radius-12 d-flex align-items-center justify-content-between" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <button class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2 add-user-button">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Ajouter
                    </button>
                </div>
                <div class="card-body p-24">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <div class="d-flex align-items-center gap-10">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <input class="form-check-input radius-4 border input-form-dark" type="checkbox" name="checkbox" id="selectAll">
                                            </div>
                                            ID
                                        </div>
                                    </th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Cible</th>
                                    <th scope="col">Jetons</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Durée</th>
                                    <th scope="col">Mis en avant</th>
                                    <th scope="col">Date de création</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packs as $pack)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-10">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <input class="form-check-input radius-4 border border-neutral-400" type="checkbox" name="checkbox">
                                            </div>
                                            {{ $pack->id }}
                                        </div>
                                    </td>
                                    
                                    <td>{{ $pack->name }}</td>
                                    <td>{{ $pack->type == 'client' ? 'Clients' : 'Professionnels' }}</td>
                                    <td>{{ $pack->coins }}</td>
                                    <td>{{ $pack->price }}</td>
                                    <td>{{ $pack->duration }} mois</td>
                                    <td class="text-center">
                                        <span class="bg-{{ $pack->highlight == 1 ? "success" : "danger" }}-focus text-{{ $pack->highlight == 1 ? "success" : "danger" }}-600 border border-{{ $pack->highlight == 1 ? "success" : "danger" }}-main px-24 py-4 radius-4 fw-medium text-sm">{{ $pack->highlight == 1 ? "Oui" : "Non" }}</span>
                                    </td>
                                    <td>{{ $pack->created_at->format('d m Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <a href="{{ route('viewPack', ['id' => $pack->id]) }}">
                                                <button type="button" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                                </button>
                                            </a>
                                            <a href="{{ route('viewPack', ['id' => $pack->id]) }}">
                                                <button type="button" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </button>
                                            </a>
                                            <form action="{{ route('deletePack', ['id' => $pack->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                        <span>Affichage de {{ $packs->firstItem() }} à {{ $packs->lastItem() }} sur {{ $packs->total() }} entrées</span>
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <li class="page-item {{ $packs->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $packs->previousPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-left" class=""></iconify-icon>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $packs->lastPage(); $i++)
                                <li class="page-item {{ $i == $packs->currentPage() ? 'active' : '' }}">
                                    <a class="page-link {{ $i == $packs->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $packs->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $packs->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $packs->nextPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-right" class=""></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-xl mb-0" id="addTaskModalLabel">Ajouter un pack</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('storePack') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-20">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Nom <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8" id="name" name="name" placeholder="Entrer le nom">
                                </div>
                                <div class="mb-20">
                                    <div class="mb-20">
                                        <label for="type" class="form-label fw-semibold text-primary-light text-sm mb-8">Cible<span class="text-danger-600">*</span> </label>
                                        <select class="form-control radius-8 form-select" id="type" name="type">
                                            <option value="client">Clients</option>
                                            <option value="professional">Professionnels</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-20">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Jetons <span class="text-danger-600">*</span></label>
                                    <input type="number" class="form-control radius-8" id="name" name="coins" placeholder="Entrer le nombre de jetons">
                                </div>
                                <div class="mb-20">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Prix <span class="text-danger-600">*</span></label>
                                    <input type="number" class="form-control radius-8" id="name" name="price" placeholder="Entrer le prix">
                                </div>
                                <div class="mb-20">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Durée (en mois) <span class="text-danger-600">*</span></label>
                                    <input type="number" class="form-control radius-8" id="name" name="duration" placeholder="Entrer la durée">
                                </div>
                                <div class="mb-20">
                                    <label for="highlight" class="form-label fw-semibold text-primary-light text-sm mb-8">Mettre en avant <span class="text-danger-600">*</span></label>
                                    <select class="form-control radius-8 form-select" id="highlight" name="highlight">
                                        <option value="0">Non</option>
                                        <option value="1">Oui</option>
                                    </select>
                                </div>
                                
                                
                                <div class="modal-footer justify-content-center gap-3">
                                    <button type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-50 py-11 radius-8" data-bs-dismiss="modal">
                                        Annuler
                                    </button>
                                    <button type="submit" class="btn btn-primary border border-primary-600 text-md px-50 py-12 radius-8">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

@endsection
