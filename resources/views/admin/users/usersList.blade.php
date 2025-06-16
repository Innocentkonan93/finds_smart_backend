@extends('admin.layout.layout')
@php
    $title='Liste des utilisateurs';
    $subTitle = 'Liste des utilisateurs';
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
            @if ($errors->any())
            <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-5 fw-semibold text-lg radius-12 d-flex align-items-center justify-content-between" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card h-100 p-0 radius-12">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                    <div class="d-flex align-items-center flex-wrap gap-3">
          
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Job</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date de création</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-10">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <input class="form-check-input radius-4 border border-neutral-400" type="checkbox" name="checkbox">
                                            </div>
                                            {{ $user->id }}
                                        </div>
                                    </td>
                                   
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->image_path ? Storage::url($user->image_path) : asset('assets/images/user-list/user-list1.png') }}" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                                            <div class="flex-grow-1">
                                                <span class="text-md mb-0 fw-normal text-secondary-light">{{ $user->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-md mb-0 fw-normal text-secondary-light">{{ $user->email }}</span></td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->jobCategory ? $user->jobCategory->name : 'N/A' }}</td>
                                    <td>{{ $user->user_type }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td class="text-center">
                                        <span class="bg-{{ $user->is_active == 1 ? "success" : "danger" }}-focus text-{{ $user->is_active == 1 ? "success" : "danger" }}-600 border border-{{ $user->is_active == 1 ? "success" : "danger" }}-main px-24 py-4 radius-4 fw-medium text-sm">{{ $user->is_active == 1 ? "Actif" : "Inactif" }}</span>
                                    </td>
                                    <td>{{ $user->created_at->format('d m Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <a href="{{ route('viewProfile', ['id' => $user->id]) }}">
                                                <button type="button" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                                </button>
                                            </a>
                                            <a href="{{ route('viewProfile', ['id' => $user->id]) }}">
                                                <button type="button" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </button>
                                            </a>
                                            <form action="{{ route('deleteUser', ['id' => $user->id]) }}" method="POST">
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
                        <span>Affichage de {{ $users->firstItem() }} à {{ $users->lastItem() }} sur {{ $users->total() }} entrées</span>
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $users->previousPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-left" class=""></iconify-icon>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $users->lastPage(); $i++)
                                <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                                    <a class="page-link {{ $i == $users->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $users->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $users->nextPageUrl() }}">
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
                            <h6 class="modal-title text-xl mb-0" id="addTaskModalLabel">Ajouter un utilisateur</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('storeUser') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-20">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Nom et prénom <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8" id="name" name="name" placeholder="Entrer le nom et prénom">
                                </div>
                                <div class="mb-20">
                                    <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span class="text-danger-600">*</span></label>
                                    <input type="email" class="form-control radius-8" id="email" name="email" placeholder="Entrer l'email">
                                </div>
                                <div class="mb-20">
                                    <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Téléphone <span class="text-danger-600">*</span></label>
                                    <input type="number" class="form-control radius-8" id="number" name="phone" placeholder="Entrer le numéro de téléphone">
                                </div>
                                <div class="mb-20">
                                    <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Date de naissance <span class="text-danger-600">*</span></label>
                                    <input type="date" class="form-control radius-8" id="number" name="birth_date" placeholder="Entrer la date de naissance">
                                </div>
                                <div class="mb-20">
                                    <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Pays <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8" id="number" name="country" placeholder="Entrer le pays">
                                </div>
                                <div class="mb-20">
                                    <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Ville <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8" id="number" name="city" placeholder="Entrer la ville">
                                </div>
                                <div class="mb-20">
                                    <label for="depart" class="form-label fw-semibold text-primary-light text-sm mb-8">Rôles <span class="text-danger-600">*</span> </label>
                                    <select class="form-control radius-8 form-select" id="depart" name="role">
                                        <option> </option>
                                        <option value="user">Utilisateur</option>
                                        <option value="admin">Administrateur</option>
                                    </select>
                                </div>
                                <div class="mb-20">
                                    <label for="depart" class="form-label fw-semibold text-primary-light text-sm mb-8">Type d'utilisateur <span class="text-danger-600">*</span> </label>
                                    <select class="form-control radius-8 form-select" id="depart" name="user_type">
                                        <option > </option>
                                        <option value="professional">Professionnel</option>
                                        <option value="client">Client</option>
                                    </select>
                                </div>
                                <div class="mb-20">
                                    <label for="depart" class="form-label fw-semibold text-primary-light text-sm mb-8">Mot de passe<span class="text-danger-600">*</span> </label>
                                    <p>Le mot de passe par défaut pour un nouvel utilisateur est : 123456</p>
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
