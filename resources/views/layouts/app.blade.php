<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Digisoft HR Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('/assets/css/styles.min.css') }}" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

                <!-- Bootstrap 5.3.3 CSS -->
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> -->

        <!-- Bootstrap Icons (latest compatible version) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- DataTables with Bootstrap 5 styling -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <!-- In <head> -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />


        <!-- jQuery (Required by DataTables) -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
         <script src="{{ asset('/assets/js/sidebarmenu.js') }}"></script>
        <script src="{{ asset('/assets/js/app.min.js') }}"></script>
        <!-- <script src="{{ asset('/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script> -->
        <script src="{{ asset('/assets/libs/simplebar/dist/simplebar.js') }}"></script>
        <!-- <script src="{{ asset('/assets/js/dashboard.js') }}"></script> -->

        <!-- Bootstrap 5.3 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- DataTables JS -->

        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.13.8/sorting/datetime-moment.js"></script>
  
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        
         <!-- In <head> -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <!-- Lottie -->
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

        <!-- Animate.css for bounce/fade effects -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

           <script>
                $(document).ready(function () {
                    $.fn.dataTable.moment('D MMM YYYY');
                  $('#usersTable').DataTable({
                    paging: true,       // Enable pagination
                    searching: true,    // Enable search box
                    ordering: true,     // Enable column sorting
                    info: true,         // Show info text ("Showing 1 to 5 of 10 entries")
                    columnDefs: [
                        { orderable: true, targets: 0 },              // Enable ordering on first column
                        { orderable: false, targets: '_all' }         // Disable ordering on all other columns
                    ]          
                  });
                   $('#usersTableHoliday').DataTable({
                    paging: true,       // Enable pagination
                    searching: true,    // Enable search box
                    ordering: true,     // Enable column sorting
                    info: true,         // Show info text ("Showing 1 to 5 of 10 entries")
                    columnDefs: [
                        { orderable: true, targets: [0, 1] },              // Enable ordering on first column
                        { orderable: false, targets: '_all' }         // Disable ordering on all other columns
                    ]          
                  });
                });

            </script>

            <script>
                const HRP_URL = "{{ config('app.hrp_url') }}";
            </script>
            <style>
      .left-sidebar,.app-header{
        top:0px !important;
      }
      .left-sidebar .scroll-sidebar {
        height: calc(100vh) !important;
        }
        .body-wrapper-inner .container-fluid{
            padding-top: 120px !important;
        }
        .proimg img {
            object-fit: cover;
            border-radius: 50%;
            height: 35px;
        }

        .destilsUser {
            display: flex;
            flex-direction: column;
        }
        .destilsUser small{
          line-height: 12px;
        }
        .btn-primary, .btn-outline-primary:hover, .btn-primary:hover,.btn-info, .btn-info:hover,
        .bg-info, .bg-info:hover{
            background: #0064b0 !important;
            border-color: #0064b0;
        }
        .btn-outline-primary{
            border-color: #0064b0;
            color: #0064b0;
        }
        .sidebar-nav ul .sidebar-item.selected > .sidebar-link.active, .sidebar-nav ul .sidebar-item.selected > .sidebar-link, .sidebar-nav ul .sidebar-item > .sidebar-link.active{
            background-color: #0064b0;
            
        }
        .sidebar-nav ul .sidebar-item .first-level .sidebar-item .sidebar-link:hover,
        .sidebar-nav ul .sidebar-item .first-level .sidebar-item .sidebar-link.active{
            color: #0064b0 !important;
        }
        input[name="profile_image"] {
            border: 1px solid;
            height: 40px;
            padding: 10px;
        }
        .ApWait {
        display: none;
        width: 100%;
        height: 100%;
        border: 0 solid black;
        position: fixed;
        top: 0;
        left: 0;
        padding: 2px;
        box-shadow: inset 0 0 0 8000px rgba(0, 0, 0, 0.3);
        z-index: 99999;
        margin-top: 0 !important;
        }

        .loader_child {
        position: absolute;
        top: 50%;
        left: 50%;
        padding: 15px;
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        -o-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);

        }

        #loading-bar-spinner.spinner {
        left: 50%;
        margin-left: -20px;
        top: 50%;
        margin-top: -20px;
        position: absolute;
        animation: loading-bar-spinner 500ms linear infinite;
        }

        #loading-bar-spinner.spinner .spinner-icon {
        width: 40px;
        height: 40px;
        border: solid 4px transparent;
        border-top-color: #fff;
        border-left-color: #fff;
        border-radius: 50%;
        -webkit-animation: initial;
        animation: initial;

        }

        @keyframes loading-bar-spinner {
        0% {
        transform: rotate(0deg);
        transform: rotate(0deg);
        }

        100% {
        transform: rotate(360deg);
        transform: rotate(360deg);
        }

        }
    small.viewfileCurrent {
        font-style: italic;
        font-weight: 600;
        color: #000;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .viewfileCurrent .bi-file-earmark-text {
        font-size: 40px;
    }
    .btn:disabled {
    cursor: not-allowed !important;
    background-color: grey;
    border-color: grey;
}
       
</style>
    </head>
    <body class="font-sans antialiased">
        <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
        
            @include('layouts.sidebar')
            

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="body-wrapper">
                <!--  Header Start -->
                <header class="app-header">
                    <nav class="navbar navbar-expand-lg navbar-light">
                      <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                          <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                          </a>
                        </li>
                      </ul>
                      <div class="navbar-collapse justify-content-end px-0" id="navbarNav">

                       @php
                          $user = auth()->user();
                          $employee = \App\Models\Employee::find($user->employee_id);

                          $profileImage = $employee && $employee->profile_image
                              ? asset('storage/' . $employee->profile_image)
                              : asset('/assets/images/profile/user-1.jpg'); // fallback image
                      @endphp
                       <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                          <li class="nav-item dropdown">
                              <a class="nav-link d-flex align-items-center gap-2" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                  <!-- Profile Image -->
                                  <div class="proimg">
                                      @php
                                        $profileImage = $user->employee->profile_image ?? null;
                                    @endphp

                                    @if($profileImage && Storage::disk('public')->exists($profileImage))
                                        <img src="{{ asset('storage/' . $profileImage) }}"
                                             alt="Profile Image"
                                             class="rounded-circle shadow"
                                             width="35">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0064b0&color=fff&size=100"
                                             alt="Default Avatar"
                                             class="rounded-circle shadow"
                                             width="35" height="35" >
                                    @endif
                                  </div>

                                  <!-- Name & Role -->
                                  <div class="destilsUser">
                                      <h6 class="mb-0 text-dark" style="font-size: 14px;">{{ $user->name }}</h6>
                                      <small class="text-muted text-capitalize" style="font-size: 12px;">{{ $user->role }}</small>
                                  </div>
                              </a>
                              <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                  <div class="message-body text-center">
    
                                      <!-- Profile Link -->
                                      <a href="{{ route('profile.viewprofile') }}" class="d-flex align-items-center gap-2 dropdown-item">
                                          <i class="ti ti-user fs-6"></i>
                                          <p class="mb-0 fs-3">My Profile</p>
                                      </a>

                                      <!-- Logout -->
                                      <form method="POST" action="{{ route('logout') }}">
                                          @csrf
                                          <a href="{{ route('logout') }}" class="btn btn-outline-primary mx-3 mt-2 d-block"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                              Logout
                                          </a>
                                      </form>
                                  </div>
                              </div>
                          </li>
                      </ul>
                      </div>
                    </nav>
                </header>
              <!--  Header End -->
                <div class="body-wrapper-inner">
                    @yield('content')
                </div>
            </main>
        </div>
        <div class="ApWait" style="display: none;">
            <div class="loader_child">
                <div id="loading-bar-spinner" class="spinner">
                    <div class="spinner-icon"></div>
                </div>
            </div>
        </div>
    </body>
</html>
