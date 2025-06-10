@extends('admin.layout.layout')
@php
    $title='Liste des metiers';
    $subTitle = 'Liste des metiers';
    $script ='<script>
                        $(".remove-item-btn").on("click", function() {
                            $(this).closest("tr").addClass("d-none")
                        });

                         document.querySelectorAll(".add-kanban, .add-user-button").forEach(button => {
                    button.addEventListener("click", function() {
                        var addTaskModal = new bootstrap.Modal(document.getElementById("addTaskModal"));
                    
                        addTaskModal.show();
                    });
                });
            </script>';
@endphp

@section('content')

            <div class="card h-100 p-0 radius-12">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
                        <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                        </select>
                        <form class="navbar-search">
                            <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </form>
                        <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                            <option>Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
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
                                    <th scope="col">Description</th>
                                    <th scope="col">Code couleur</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobCategories as $jobCategory)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-10">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <input class="form-check-input radius-4 border border-neutral-400" type="checkbox" name="checkbox">
                                            </div>
                                            {{ $jobCategory->id }}
                                        </div>
                                    </td>
                                    <td>{{ $jobCategory->name }}</td>
                                    <td>{{ $jobCategory->description }}</td>
                                    <td>{{ $jobCategory->color }}</td>
                                    <td class="text-center">
                                        <span class="bg-{{ $jobCategory->is_active == 1 ? "success" : "danger" }}-focus text-{{ $jobCategory->is_active == 1 ? "success" : "danger" }}-600 border border-{{ $jobCategory->is_active == 1 ? "success" : "danger" }}-main px-24 py-4 radius-4 fw-medium text-sm">{{ $jobCategory->is_active == 1 ? "Actif" : "Inactif" }}</span>
                                    </td>
                                    <td>{{ $jobCategory->created_at ? $jobCategory->created_at->format('d m Y') : 'N/A' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <a href="{{ route('viewJob', ['id' => $jobCategory->id]) }}">
                                                <button type="button" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                                </button>
                                            </a>
                                            <a href="{{ route('updateJob', ['id' => $jobCategory->id]) }}">
                                                <button type="button" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </button>
                                            </a>
                                            <form action="{{ route('deleteJob', ['id' => $jobCategory->id]) }}" method="POST">
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
                        <span>Affichage de {{ $jobCategories->firstItem() }} à {{ $jobCategories->lastItem() }} sur {{ $jobCategories->total() }} entrées</span>
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <li class="page-item {{ $jobCategories->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $jobCategories->previousPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-left" class=""></iconify-icon>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $jobCategories->lastPage(); $i++)
                                <li class="page-item {{ $i == $jobCategories->currentPage() ? 'active' : '' }}">
                                    <a class="page-link {{ $i == $jobCategories->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $jobCategories->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $jobCategories->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $jobCategories->nextPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-right" class=""></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

             <!-- Add Job Modal -->
             <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-xl mb-0" id="addTaskModalLabel">Ajouter un metier</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('storeJob') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-20">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Nom du metier <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8" id="name" name="name" placeholder="Entrer le nom du metier">
                                </div>
                                <div class="mb-20">
                                    <label for="description" class="form-label fw-semibold text-primary-light text-sm mb-8">Description <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8" id="description" name="description" placeholder="Entrer la description du metier">
                                </div>
                                <div class="mb-20">
                                    <label for="color" class="form-label fw-semibold text-primary-light text-sm mb-8">Code couleur <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8" id="color" name="color" placeholder="Entrer le code couleur">
                                </div>
                         
                                <div class="mb-20">
                                    <label for="depart" class="form-label fw-semibold text-primary-light text-sm mb-8">Status <span class="text-danger-600">*</span> </label>
                                    <select class="form-control radius-8 form-select" id="depart" name="status" value="1">
                                        <option> </option>
                                        <option value="1">Actif</option>
                                        <option value="0">Inactif</option>
                                    </select>
                                </div>
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
