@extends('admin.layout.layout')
@php
    $title='Liste des professionnels';
    $subTitle = 'Liste des professionnels';
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
                                    <td>{{ $user->user_type == 'professional' ? 'Professionnel' : 'Client' }}</td>
                                    <td>{{ $user->role == 'admin' ? 'Admin' : 'Utilisateur' }}</td>
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

@endsection
