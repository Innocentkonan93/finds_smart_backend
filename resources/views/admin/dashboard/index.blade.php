@extends('admin.layout.layout')

@php
    $title='Dashboard';
    $subTitle = 'AI';
    $script= '<script src="' . asset('assets/js/homeOneChart.js') . '"></script>';
@endphp

@section('content')
<script>
    window.ordersData = @json($ordersData);
    window.weeklyOrderData = @json($weeklyOrderData);
    window.transactionStats = @json($transactionStats);
</script>

            <div class="row row-cols-xxxl-5 row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4">
                <div class="col">
                    <div class="card shadow-none border bg-gradient-start-1 h-100">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1"> Utilisateurs</p>
                                    <h6 class="mb-0">{{ $allUsers }}</h6>
                                </div>
                                <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="gridicons:multiple-users" class="text-white text-2xl mb-0"></iconify-icon>
                                </div>
                            </div>
                            {{-- <div class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center gap-1 text-{{ $usersChange >= 0 ? 'success' : 'danger' }}-main">
                                    <iconify-icon icon="{{ $usersChange >= 0 ? 'bxs:up-arrow' : 'bxs:down-arrow' }}" class="text-xs"></iconify-icon> {{ $usersChange }}
                                </span>
                            </div>
                            <p class="fw-medium text-sm text-primary-light mb-0 d-flex align-items-center gap-2">
                                Les 30 derniers jours
                            </p> --}}
                        </div>
                    </div><!-- card end -->
                </div>
                <div class="col">
                    <div class="card shadow-none border bg-gradient-start-2 h-100">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1">Clients</p>
                                    <h6 class="mb-0">{{ $totalClients }}</h6>
                                </div>
                                <div class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="fa-solid:award" class="text-white text-2xl mb-0"></iconify-icon>
                                </div>
                            </div>
                            {{-- <p class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center gap-1 text-{{ $clientsChange >= 0 ? 'success' : 'danger' }}-main">
                                    <iconify-icon icon="{{ $clientsChange >= 0 ? 'bxs:up-arrow' : 'bxs:down-arrow' }}" class="text-xs"></iconify-icon> {{ $clientsChange }}
                                </span>
                                Les 30 derniers jours
                            </p> --}}
                        </div>
                    </div><!-- card end -->
                </div>
                <div class="col">
                    <div class="card shadow-none border bg-gradient-start-3 h-100">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1">Professionnels</p>
                                    <h6 class="mb-0">{{ $professionalsCount }}</h6>
                                </div>
                                <div class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="fluent:people-20-filled" class="text-white text-2xl mb-0"></iconify-icon>
                                </div>
                            </div>
                            {{-- <p class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center gap-1 text-{{ $professionalsChange >= 0 ? 'success' : 'danger' }}-main">
                                    <iconify-icon icon="{{ $professionalsChange >= 0 ? 'bxs:up-arrow' : 'bxs:down-arrow' }}" class="text-xs"></iconify-icon> {{ $professionalsChange }}
                                </span>
                                Les 30 derniers jours
                            </p> --}}
                        </div>
                    </div><!-- card end -->
                </div>
                <div class="col">
                    <div class="card shadow-none border bg-gradient-start-4 h-100">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1">Commandes</p>
                                    <h6 class="mb-0">{{ number_format($totalOrdersPrice, 0, ',', ' ') }} F</h6>
                                </div>
                                <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="solar:wallet-bold" class="text-white text-2xl mb-0"></iconify-icon>
                                </div>
                            </div>
                            {{-- <p class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center gap-1 text-success-main">
                                    <iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon> {{ number_format($ordersPriceChange, 0, ',', ' ') }} F
                                </span>
                                Les 30 derniers jours
                            </p> --}}   
                        </div>
                    </div><!-- card end -->
                </div>
                <div class="col">
                    <div class="card shadow-none border bg-gradient-start-5 h-100">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1">Cmdes en attente</p>
                                    <h6 class="mb-0">{{ number_format($totalOrdersPending, 0, ',', ' ') }} F</h6>
                                </div>
                                <div class="w-50-px h-50-px bg-red rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="fa6-solid:file-invoice-dollar" class="text-white text-2xl mb-0"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div><!-- card end -->
                </div>
            </div>

            <div class="row gy-4 mt-1">
                <div class="col-xxl-6 col-xl-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <h6 class="text-lg mb-0">Statistiques des commandes</h6>
                                <select class="form-select bg-base form-select-sm w-auto">
                                    <option>{{ now()->year }}</option>
                                </select>
                            </div>
                            <div class="d-flex flex-wrap align-items-center gap-2 mt-8">
                                <h6 class="mb-0">{{ number_format($totalOrdersPrice, 0, ',', ' ') }} F</h6>
                            </div>
                            <div id="chart" class="pt-28 apexcharts-tooltip-style-1"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-6">
                    <div class="card h-100 radius-8 border">
                        <div class="card-body p-24">
                            <h6 class="mb-12 fw-semibold text-lg mb-16">Total Commandes de la semaine</h6>
                            <div class="d-flex align-items-center gap-2 mb-20">
                                <h6 class="fw-semibold mb-0">{{ number_format($weeklyOrderDataTotalPrice, 0, ',', ' ') }} F</h6>
                            </div>
                            <div id="barChart" class="barChart"></div>

                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-6">
                    <div class="card h-100 radius-8 border-0 overflow-hidden">
                        <div class="card-body p-24">
                            <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                                <h6 class="mb-2 fw-bold text-lg">Statistiques des transactions</h6>
                                <div class="">
                                    <select class="form-select form-select-sm w-auto bg-base border text-secondary-light">
                                        <option>{{ now()->format('F') }}</option>
                                    </select>
                                </div>
                            </div>


                            <div id="userOverviewDonutChart" class="apexcharts-tooltip-z-none"></div>

                            <div class="row mt-3">
                                <div class="col-md-4 d-flex align-items-center gap-1    ">
                                    <span class="w-12-px h-12-px radius-2 bg-primary-600"></span>
                                    <span class="text-secondary-light text-sm fw-normal">Validé:
                                        <span class="text-primary-light fw-semibold">{{ $transactionStats['completed_payment'] }}</span>
                                    </span>
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-1    ">
                                    <span class="w-12-px h-12-px radius-2 bg-yellow"></span>
                                    <span class="text-secondary-light text-sm fw-normal">En att.:
                                        <span class="text-primary-light fw-semibold">{{ $transactionStats['pending_payment'] }}</span>
                                    </span>
                                </div>
                                <div class="col-md-4 d-flex align-items-center gap-1    ">
                                    <span class="w-12-px h-12-px radius-2 bg-danger"></span>
                                    <span class="text-secondary-light text-sm fw-normal">Échec:
                                        <span class="text-primary-light fw-semibold">{{ $transactionStats['failed_payment'] }}</span>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xxl-9 col-xl-12">
                    <div class="card h-100">
                        <div class="card-body p-24">

                            <div class="d-flex flex-wrap align-items-center gap-1 justify-content-between mb-16">
                                <ul class="nav border-gradient-tab nav-pills mb-0" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link d-flex align-items-center active" id="pills-to-do-list-tab" data-bs-toggle="pill" data-bs-target="#pills-to-do-list" type="button" role="tab" aria-controls="pills-to-do-list" aria-selected="true">
                                            Derniers inscrits
                                            <span class="text-sm fw-semibold py-6 px-12 bg-neutral-500 rounded-pill text-white line-height-1 ms-12 notification-alert">{{ $lastUsers->count() }}</span>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link d-flex align-items-center" id="pills-recent-leads-tab" data-bs-toggle="pill" data-bs-target="#pills-recent-leads" type="button" role="tab" aria-controls="pills-recent-leads" aria-selected="false" tabindex="-1">
                                            Dernières abonnements
                                            <span class="text-sm fw-semibold py-6 px-12 bg-neutral-500 rounded-pill text-white line-height-1 ms-12 notification-alert">{{ $lastSubscriptions->count() }}</span>
                                        </button>
                                    </li>
                                </ul>
                                 
                            </div>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-to-do-list" role="tabpanel" aria-labelledby="pills-to-do-list-tab" tabindex="0">
                                    <div class="table-responsive scroll-sm">
                                        <table class="table bordered-table sm-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Utilisateurs </th>
                                                    <th scope="col">Ville</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Inscrit le</th>
                                                    <th scope="col" class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($lastUsers as $user)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $user->image_path ? Storage::url($user->image_path) :   asset('assets/images/users/user1.png') }}" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                                                            <div class="flex-grow-1">
                                                                <h6 class="text-md mb-0 fw-medium">{{$user->name}}</h6>
                                                                <span class="text-sm text-secondary-light fw-medium">{{$user->email}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $user->city }}</td>
                                                    <td>{{ ucfirst($user->user_type) }}</td>
                                                    <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                                                    <td class="text-center">
                                                        <span class="bg-{{$user->is_active == 1 ? 'success' : 'danger'}}-focus text-{{$user->is_active == 1 ? 'success' : 'danger'}}-main px-24 py-4 rounded-pill fw-medium text-sm">{{$user->is_active == 1 ? 'Actif' : 'Inactif'}}</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-recent-leads" role="tabpanel" aria-labelledby="pills-recent-leads-tab" tabindex="0">
                                    <div class="table-responsive scroll-sm">
                                        <table class="table bordered-table sm-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Utilisateurs </th>
                                                    <th scope="col">Date d'abonnement</th>
                                                    <th scope="col">Pack</th>
                                                    <th scope="col" class="text-center">Statut</th>
                                                </tr>
                                            </thead>
                                            @foreach($lastSubscriptions as $subscription)
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $subscription->user->image_path ? Storage::url($subscription->user->image_path) :   asset('assets/images/users/user1.png') }}" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                                                            <div class="flex-grow-1">
                                                                <h6 class="text-md mb-0 fw-medium">{{$subscription->user->name}}</h6>
                                                                <span class="text-sm text-secondary-light fw-medium">{{$subscription->user->email}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $subscription->created_at->format('d M Y') }}</td>
                                                    <td>{{$subscription->pack->name}}</td>
                                                    <td class="text-center">
                                                        <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                                <h6 class="mb-2 fw-bold text-lg mb-0">Top Performances</h6>
                            </div>

                            <div class="mt-32">
                                @foreach($topProfessionals as $professional)    
                                <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $professional->professional->image_path ? Storage::url($professional->professional->image_path) :   asset('assets/images/users/user1.png') }}" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                                        <div class="flex-grow-1">
                                            <h6 class="text-md mb-0 fw-medium">{{ $professional->professional->name }}</h6>
                                            <span class="text-sm text-secondary-light fw-medium">{{ $professional->professional->email }}</span>
                                        </div>
                                    </div>
                                    <span class="text-primary-light text-md fw-medium">{{ number_format($professional->total_amount, 0, ',', ' ') }} F</span>
                                </div>
                                @endforeach
                                 

                            </div>

                        </div>
                    </div>
                </div>
                
            </div>

@endsection