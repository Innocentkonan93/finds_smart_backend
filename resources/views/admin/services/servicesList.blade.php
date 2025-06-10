@extends('admin.layout.layout')
@php
    $title='Liste des services';
    $subTitle = 'Liste des services';
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
                                    <th scope="col">Titre</th>
                                    <th scope="col">Catégorie</th>
                                    <th scope="col">Salaire</th>
                                    <th scope="col">Date de début</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Mode</th>
                                    <th scope="col">Professionnel</th>
                                    <th scope="col">Date de création</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-10">
                                            <div class="form-check style-check d-flex align-items-center">
                                                <input class="form-check-input radius-4 border border-neutral-400" type="checkbox" name="checkbox">
                                            </div>
                                            {{ $service->id }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $service->image_path ? Storage::url($service->image_path) : asset('assets/images/user-list/user-list1.png') }}" alt="" class="w-40-px h-40-px flex-shrink-0 me-12 overflow-hidden">
                                            <div class="flex-grow-1">
                                                <span class="text-md mb-0 fw-normal text-secondary-light">{{ $service->title }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-md mb-0 fw-normal text-secondary-light">{{ $service->category ? $service->category->name : 'N/A' }}</span></td>
                                    <td>{{ number_format($service->salary, 0, ',', ' ') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($service->start_date)->format('d m Y') }}</td>
                                    <td>{{ $service->city }}</td>
                                    <td>{{ $service->mode == 'temporary'? 'Temps partiel' : 'Temps plein' }}</td>
                                    <td>{{ $service->professional ? $service->professional->name : 'N/A' }}</td>
                                    <td>{{ $service->created_at->format('d m Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <a href="{{ route('viewService', ['id' => $service->id]) }}">
                                                <button type="button" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                                </button>
                                            </a>
                                            <a href="{{ route('viewService', ['id' => $service->id]) }}">
                                                <button type="button" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </button>
                                            </a>
                                            <form action="{{ route('deleteService', ['id' => $service->id]) }}" method="POST">
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
                        <span>Affichage de {{ $services->firstItem() }} à {{ $services->lastItem() }} sur {{ $services->total() }} entrées</span>
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            <li class="page-item {{ $services->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $services->previousPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-left" class=""></iconify-icon>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $services->lastPage(); $i++)
                                <li class="page-item {{ $i == $services->currentPage() ? 'active' : '' }}">
                                    <a class="page-link {{ $i == $services->currentPage() ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-secondary-light' }} fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $services->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $services->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link bg-neutral-200 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="{{ $services->nextPageUrl() }}">
                                    <iconify-icon icon="ep:d-arrow-right" class=""></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

@endsection
