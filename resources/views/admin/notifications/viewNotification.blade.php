@extends('admin.layout.layout')
@php
        $title='Notification';
        $subTitle = 'Notification';
        $script ='<script>
                        // ========================= Adjust Textarea Height depending of text lines(default height 40px) Js Start ===========================
                        function adjustHeight(textarea) {
                            // Calculate the scroll height of the content
                            let scrollHeight = textarea.scrollHeight;

                            // Set the textarea height to the scroll height, but not exceeding the maximum height
                            if (scrollHeight > 44 && scrollHeight <= 60) {
                                textarea.style.height = scrollHeight + "px";
                            } else if (scrollHeight > 60) {
                                // textarea.style.height = "60px !important";
                                textarea.setAttribute("style", "height: 60px !important;");
                            }
                        }
                        // ========================= Adjust Textarea Height depending of text lines(default height 40px) Js End ===========================
                  </script>';
@endphp

@section('content')

        <div class="row gy-4">
            <div class="col-xxl-12">
                <div class="card h-100 p-0 email-card overflow-x-auto d-block">
                    <div class="min-w-450-px d-flex flex-column justify-content-between h-100">
                        <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center gap-3 justify-content-between flex-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('notificationsList') }}" class="text-secondary-light d-flex me-8">
                                    <iconify-icon icon="mingcute:arrow-left-line" class="icon fs-3 line-height-1"></iconify-icon>
                                </a>
                                <h6 class="mb-0 text-lg">{{ $notification->data['title'] }}</h6>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                
                              <form action="{{ route('deleteNotification', $notification->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-secondary-light d-flex">
                                    <iconify-icon icon="material-symbols:delete-outline" class="icon text-xxl line-height-1"></iconify-icon>
                                </button>
                              </form>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="py-16 px-24 border-bottom">
                                <div class="d-flex align-items-start gap-3">
                                    {{-- <img src="{{ asset('assets/images/user-list/user-list1.png') }}" alt="" class="w-40-px h-40-px rounded-pill"> --}}
                                    <div class="w-40-px h-40-px d-flex align-items-center justify-content-center bg-primary-50 rounded-pill">
                                        <iconify-icon icon="hugeicons:notification-02" width="24" height="24"></iconify-icon>
                                    </div>
                                    <div class="">
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <h6 class="mb-0 text-lg">{{ $notification->data['title'] }}</h6>
                                        </div>
                                        <div class="mt-20">
                                            <p class="mb-16 text-primary-light">{{ $notification->data['message'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
