<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<x-head />

<body>

  @auth
  <x-sidebar :user="Auth::user()" />
  @endauth

    <main class="dashboard-main">

        <!-- ..::  navbar start ::.. -->
        @auth
        <x-navbar :user="Auth::user()" />
        @endauth
        <!-- ..::  navbar end ::.. -->
        <div class="dashboard-main-body">
            
            <!-- ..::  breadcrumb  start ::.. -->
            <x-breadcrumb title='{{ isset($title) ? $title : "" }}' subTitle='{{ isset($subTitle) ? $subTitle : "" }}' />
            <!-- ..::  header area end ::.. -->

            @yield('content')
        
        </div>
        <!-- ..::  footer  start ::.. -->
        <x-footer />
        <!-- ..::  footer area end ::.. -->

    </main>

    <!-- ..::  scripts  start ::.. -->
    <x-script  script='{!! isset($script) ? $script : "" !!}' />
    <!-- ..::  scripts  end ::.. -->

</body>
@guest
    <script>window.location.href = "{{ route('admin.signin') }}";</script>
@endguest



@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
  <div class="toast hide align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
    <div class="toast-header">
      <strong class="me-auto text-success">Succès </strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="d-flex">
      <div class="toast-body">
        {{ session('success') }}
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var toastEl = document.querySelector('.toast');
    var toast = new bootstrap.Toast(toastEl);
    toast.show();
  });
</script>
@endif
</html>