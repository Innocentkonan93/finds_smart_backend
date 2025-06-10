@extends('admin.layout.layout')
@php
    $title='Liste des documents';
    $subTitle = 'Liste des documents';
    $script ='<script>
                        $(".remove-item-btn").on("click", function() {
                            $(this).closest("tr").addClass("d-none")
                        });
            </script>';
@endphp

@section('content')

            <div class="card h-100 p-0 radius-12">
           
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
                                    <th scope="col">Date</th>
                                    <th scope="col">Fichier</th>
                                    <th scope="col">Utilisateur</th>
                                    <th scope="col">Type</th>
                                    <th scope="col" class="text-center">Statut</th>
                                    <th scope="col">Date de modification</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documents as $document)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-10">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <input class="form-check-input radius-4 border border-neutral-400" type="checkbox" name="checkbox">
                                            </div>
                                            {{ $document->id }}
                                        </div>
                                    </td>
                                    <td>{{ $document->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $document->file_path ? Storage::url($document->file_path) : asset('assets/images/user-list/user-list1.png') }}" alt="" class="w-60-px h-40-px  flex-shrink-0 me-12 overflow-hidden">
                                        </div>
                                    </td>
                                    <td>{{ $document->user->name }}</td>
                                    <td>{{ $document->type }}</td>
                                    <td class="text-center">
                                        <span class="bg-{{ $document->is_validated == 1 ? "success" : "danger" }}-focus text-{{ $document->is_validated == 1 ? "success" : "danger" }}-600 border border-{{ $document->is_validated == 1 ? "success" : "danger" }}-main px-24 py-4 radius-4 fw-medium text-sm">{{ $document->is_validated == 1 ? "Validé" : "Non validé" }}</span>
                                    </td>
                                    <td>{{ $document->updated_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <a href="{{ route('viewDocument', ['id' => $document->id]) }}">
                                                <button type="button" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                                </button>
                                            </a>
                                            <a href="{{ route('viewDocument', ['id' => $document->id]) }}">
                                                <button type="button" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </button>
                                            </a>
                                            <form action="{{ route('deleteDocument', ['id' => $document->id]) }}" method="POST">
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
                        <span>Affichage de {{ $documents->firstItem() }} à {{ $documents->lastItem() }} sur {{ $documents->total() }} entrées</span>
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <li class="page-item {{ $documents->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $documents->previousPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-left" class=""></iconify-icon>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $documents->lastPage(); $i++)
                                <li class="page-item {{ $i == $documents->currentPage() ? 'active' : '' }}">
                                    <a class="page-link {{ $i == $documents->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $documents->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $documents->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $documents->nextPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-right" class=""></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

@endsection
