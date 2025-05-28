@extends('admin.layout.layout')

@php
    $title='Notifications';
    $subTitle = 'Notifications';
    $script = '<script>
                    // Table Header Checkbox checked all js Start
                    $("#selectAll").on("change", function() {
                        $(".form-check .form-check-input").prop("checked", $(this).prop("checked"));

                        if ($(this).prop("checked")) {
                            $(".email-item").addClass("active");
                        } else {
                            $(".email-item").removeClass("active");
                        }
                    });

                    // Active Item with js
                    $(".form-check .form-check-input").on("change", function() {
                        if ($(this).is(":checked")) {
                            $(this).closest(".email-item").addClass("active");
                        } else {
                            $(this).closest(".email-item").removeClass("active");
                        }
                    });

                    // Selected Checkbox count amount js Start
                    $(".email-card .form-check-input").on("change", function() {
                        let selectedCount = $(".email-card .form-check-input:checked").length;

                        if (selectedCount > 0) {
                            $(".delete-button").removeClass("d-none");
                        } else {
                            $(".delete-button").addClass("d-none")
                        }
                    });
                    // Selected Checkbox count amount js End

                    $(".delete-button").on("click", function() {
                        $(".email-item.active").addClass("d-none")
                    });

                    // Page Reload Js
                    $(".reload-button").on("click", function() {
                        history.go(0);
                    });

                    // Starred Button js
                    $(".starred-button").on("click", function() {
                        $(this).toggleClass("active")
                    });
                </script>';
@endphp

@section('content')

            <div class="row gy-4">
                
                <div class="col-xxl-12">
                    <div class="card h-100 p-0 email-card">
                        <div class="card-header border-bottom bg-base py-16 px-24">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="form-check style-check d-flex align-items-center">
                                        <input class="form-check-input radius-4 border input-form-dark" type="checkbox" name="checkbox" id="selectAll">
                                        <div class="dropdown line-height-1">
                                            <button type="button" data-bs-toggle="dropdown" aria-expanded="false" class="line-height-1 d-flex">
                                                <iconify-icon icon="typcn:arrow-sorted-down" class="icon line-height-1"></iconify-icon>
                                            </button>
                                            {{-- <ul class="dropdown-menu p-12 border bg-base shadow">
                                                <li>
                                                    <button type="button" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" data-bs-toggle="modal" data-bs-target="#exampleModalView">
                                                        All
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" data-bs-toggle="modal" data-bs-target="#exampleModalEdit">
                                                        None
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" data-bs-toggle="modal" data-bs-target="#exampleModalEdit">
                                                        Read
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" data-bs-toggle="modal" data-bs-target="#exampleModalEdit">
                                                        Unread
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" data-bs-toggle="modal" data-bs-target="#exampleModalEdit">
                                                        Starred
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" data-bs-toggle="modal" data-bs-target="#exampleModalEdit">
                                                        Unstarred
                                                    </button>
                                                </li>
                                            </ul> --}}
                                        </div>
                                    </div>
                                    <button type="button" class="delete-button d-none text-secondary-light text-xl d-flex">
                                        <iconify-icon icon="material-symbols:delete-outline" class="icon line-height-1"></iconify-icon>
                                    </button>
                                    <button type="button" class="reload-button text-secondary-light text-xl d-flex">
                                        <iconify-icon icon="tabler:reload" class="icon"></iconify-icon>
                                    </button>
                                    <div class="dropdown">
                                        <button type="button" data-bs-toggle="dropdown" aria-expanded="false" class=" d-flex">
                                            <iconify-icon icon="entypo:dots-three-vertical" class="icon text-primary-light"></iconify-icon>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-lg p-12 border bg-base shadow">
                                            <li>
                                                <form action="{{ route('markAllAsRead') }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-10">
                                                        <iconify-icon icon="gravity-ui:envelope-open" class="icon text-lg line-height-1"></iconify-icon>
                                                        Marquer toutes comme lues
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    <form class="navbar-search d-lg-block d-none">
                                        <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search">
                                        <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                                    </form>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="text-secondary-light line-height-1"> {{ $notifications->count() }}</span>
                                    {{-- <span class="text-secondary-light line-height-1"{{}}>  1-12 of 1,253</span> --}}
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <li class="page-item {{ $notifications->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link d-flex bg-base border text-secondary-light text-xl" href="{{ $notifications->previousPageUrl() }}">
                                                    <iconify-icon icon="iconamoon:arrow-left-2" class="icon"></iconify-icon>
                                                </a>
                                            </li>
                                            <li class="page-item {{ $notifications->hasMorePages() ? '' : 'disabled' }}">
                                                <a class="page-link d-flex bg-base border text-secondary-light text-xl" href="{{ $notifications->nextPageUrl() }}">
                                                    <iconify-icon icon="iconamoon:arrow-right-2" class="icon"></iconify-icon>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="overflow-x-auto">
                                @forelse ($notifications as $notification)
                                <form action="{{ route('markAsRead', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <li class="email-item px-24 py-16 d-flex gap-4 align-items-center border-bottom cursor-pointer {{ $notification->read_at ? 'bg-neutral-50' : '' }} bg-hover-neutral-200 min-w-max-content ">
                                        <div class="form-check style-check d-flex align-items-center">
                                            <input class="form-check-input radius-4 border border-neutral-400" type="checkbox" name="checkbox">
                                        </div>
                                        <button type="button" class="starred-button icon text-xl text-secondary-light line-height-1 d-flex">
                                            <iconify-icon icon="ph:star" class="icon-outline line-height-1"></iconify-icon>
                                            <iconify-icon icon="ph:star-fill" class="icon-fill line-height-1 text-warning-600"></iconify-icon>
                                        </button>
                                        <button type="submit" class="text-primary-light fw-medium text-md text-line-1 w-190-px">{{ $notification->data['title'] }}</button>
                                        <button type="submit" class="text-primary-light fw-medium mb-0 text-line-1 max-w-740-px">{{ $notification->data['message'] }}</button>
                                        <span class="text-primary-light fw-medium min-w-max-content ms-auto">{{ $notification->created_at->diffForHumans() }}</span>
                                    </li>
                                </form>
                                @empty
                                <li class="px-24 py-16 text-center text-secondary-light">
                                    Aucune notification disponible.
                                </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

@endsection