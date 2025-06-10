@extends('admin.layout.layout')
@php
    $title='Liste des annonces';
    $subTitle = 'Liste des annonces';
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
                                    <th scope="col">Client</th>
                                    <th scope="col">Categorie</th>
                                    <th scope="col">Titre</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Budget</th>
                                    <th scope="col">Date de début</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Quartier</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ads as $ad)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-10">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <input class="form-check-input radius-4 border border-neutral-400" type="checkbox" name="checkbox">
                                            </div>
                                            {{ $ad->id }}
                                        </div>
                                    </td>
                                    <td>{{ $ad->user->name }}</td>
                                    <td>{{ $ad->category->name }}</td>
                                    <td>{{ $ad->title }}</td>
                                    <td>{{ $ad->description }}</td>
                                    <td>{{ number_format($ad->budget, 0, ',', ' ') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ad->start_date)->format('d m Y') }}</td>
                                    <td>{{ $ad->city }}</td>
                                    <td>{{ $ad->district }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ad->created_at)->format('d m Y') }}</td>
                                    <td class="text-center">
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
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <a href="{{ route('viewAd', ['id' => $ad->id]) }}">
                                                <button type="button" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                                </button>
                                            </a>
                                            <a href="{{ route('viewAd', ['id' => $ad->id]) }}">
                                                <button type="button" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </button>
                                            </a>
                                            <form action="{{ route('deleteAd', ['id' => $ad->id]) }}" method="POST">
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
                        <span>Affichage de {{ $ads->firstItem() }} à {{ $ads->lastItem() }} sur {{ $ads->total() }} entrées</span>
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <li class="page-item {{ $ads->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $ads->previousPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-left" class=""></iconify-icon>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $ads->lastPage(); $i++)
                                <li class="page-item {{ $i == $ads->currentPage() ? 'active' : '' }}">
                                    <a class="page-link {{ $i == $ads->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $ads->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $ads->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $ads->nextPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-right" class=""></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

             <!-- Add User Modal -->
             <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-xl mb-0" id="addTaskModalLabel">Ajouter une annonce</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('storeAd') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-20">
                                    <label for="depart" class="form-label fw-semibold text-primary-light text-sm mb-8">Client <span class="text-danger-600">*</span> </label>
                                    <select class="form-control radius-8 form-select" id="depart" name="user_id">
                                        <option> </option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-20">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Titre <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8" id="name" name="title" placeholder="Entrer le nom et prénom">
                                </div>
                                <div class="mb-20">
                                    <div class="mb-20">
                                        <label for="category_id" class="form-label fw-semibold text-primary-light text-sm mb-8">Type de service <span class="text-danger-600">*</span> </label>
                                        <select class="form-control radius-8 form-select" id="category_id" name="category_id">
                                            <option> </option>
                                            @foreach ($jobCategories as $jobCategory)
                                                <option value="{{ $jobCategory->id }}">{{ $jobCategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-20">
                                    <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Budget <span class="text-danger-600">*</span></label>
                                    <input type="number" class="form-control radius-8" id="number" name="budget" placeholder="Entrer le budget">
                                </div>
                                <div class="mb-20">
                                    <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Date de début <span class="text-danger-600">*</span></label>
                                    <input type="date" class="form-control radius-8" id="number" name="start_date" placeholder="Entrer la date de début">
                                </div>
                                <div class="mb-20">
                                    <label for="city" class="form-label fw-semibold text-primary-light text-sm mb-8">Ville <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8" id="city" name="city" placeholder="Entrer la ville">
                                </div>
                                <div class="mb-20">
                                    <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Quartier <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8" id="number" name="district" placeholder="Entrer le quartier">
                                </div>
                                <div class="mb-20">
                                    <label for="depart" class="form-label fw-semibold text-primary-light text-sm mb-8">Description <span class="text-danger-600">*</span> </label>
                                    <textarea class="form-control radius-8" id="depart" name="description" placeholder="Entrer la description"></textarea>
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
