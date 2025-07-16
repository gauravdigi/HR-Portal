    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          @php
              $user = Auth::user();
              $dashboardRoute = match($user->role) {
                  'admin' => route('admin.index'),
                  'hr' => route('hr.index'),
                  'employee' => route('employe.dashboard'),
                  'accountant' => route('accountant.employe.index'),
                  default => url('/login'), // fallback route
              };
          @endphp
          <a href="{{ $dashboardRoute }}" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/logos/logo.svg') }}" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-6"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
                @php
                      $href = '#'; // fallback
                      if (auth()->check()) {
                          $role = auth()->user()->role;

                          if ($role === 'hr') {
                              $href = route('hr.index');
                          }  elseif ($role === 'admin') {
                              $href = route('admin.index');
                          }
                      }
                  @endphp
                @auth
                @if(auth()->user()->role == 'hr' || auth()->user()->role == 'admin')
                <li class="sidebar-item">
                    <a class="sidebar-link justify-content-between"  
                    href="{{ $href }}">
                      <div class="d-flex align-items-center gap-3">
                        <span class="d-flex">
                          <i class="bi bi-speedometer2"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                      </div>
                    </a>
                </li>
                @endif
               @endauth
            <li class="sidebar-item">
              <a class="sidebar-link justify-content-between has-arrow employeeHit" href="javascript:void(0)" aria-expanded="false">
                
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-layout-grid"></i>
                  </span>
                  <span class="hide-menu">Employee</span>
                </div>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  @php
                      $href = '#'; // fallback
                      if (auth()->check()) {
                          $role = auth()->user()->role;

                          if ($role === 'hr') {
                              $href = route('hr.dashboard');
                          } elseif ($role === 'accountant') {
                              $href = route('accountant.employe.index');
                          } elseif ($role === 'admin') {
                              $href = route('admin.dashboard');
                          }
                      }
                  @endphp
                  <a class="sidebar-link justify-content-between employeelistHit"  
                    href="{{ $href }}">
                    <div class="d-flex align-items-center gap-3">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="bi bi-ui-checks"></i>
                      </div>
                      <span class="hide-menu">Employees List</span>
                    </div>
                    
                  </a>
                </li>
                @php
                      $href = '#'; // fallback
                      if (auth()->check()) {
                          $role = auth()->user()->role;

                          if ($role === 'hr') {
                              $href = route('hr.employe.create');
                          }  elseif ($role === 'admin') {
                              $href = route('admin.employe.create');
                          }
                      }
                  @endphp
                @auth
                  @if(auth()->user()->role == 'hr' || auth()->user()->role == 'admin')
                    <li class="sidebar-item">

                      <a class="sidebar-link justify-content-between create_employee_btn"  
                        href="{{ $href }}" id="create_employee_btn">
                        <div class="d-flex align-items-center gap-3">
                          <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-plus"></i>
                          </div>
                          <span class="hide-menu">Add Employees</span>
                        </div>
                        
                      </a>
                    </li>
                  @endif
                @endauth
              </ul>
            </li>
              @php
                  $href = '#'; // fallback
                  if (auth()->check()) {
                      $role = auth()->user()->role;

                      if ($role === 'hr') {
                          $href = route('holiday.index');
                      }  elseif ($role === 'admin') {
                          $href = route('holiday.index');
                      }
                  }
              @endphp
              @auth
              @if(auth()->user()->role == 'hr' || auth()->user()->role == 'admin')
              <li class="sidebar-item">
                  <a class="sidebar-link justify-content-between"  
                  href="{{ $href }}">
                    <div class="d-flex align-items-center gap-3">
                      <span class="d-flex">
                        <i class="bi bi-calendar3 me-1"></i>
                      </span>
                      <span class="hide-menu">Holiday List</span>
                    </div>
                  </a>
              </li>
              @endif
             @endauth
                                       @php
                  $href = '#'; // fallback
                  if (auth()->check()) {
                      $role = auth()->user()->role;

                      if ($role === 'hr') {
                          $href = route('candidates.index');
                      }  elseif ($role === 'admin') {
                          $href = route('candidates.index');
                      }
                  }
              @endphp
              @auth
              @if(auth()->user()->role == 'hr' || auth()->user()->role == 'admin')
              <li class="sidebar-item">
                  <a class="sidebar-link justify-content-between"  
                  href="{{ $href }}">
                    <div class="d-flex align-items-center gap-3">
                      <span class="d-flex">
                        <i class="bi bi-person-bounding-box"></i>
                      </span>
                      <span class="hide-menu">Candidates</span>
                    </div>
                  </a>
              </li>
              @endif
             @endauth
             @php
                  $href = '#'; // fallback
                  if (auth()->check()) {
                      $role = auth()->user()->role;

                      if ($role === 'hr') {
                          $href = route('hiringportal.index');
                      }  elseif ($role === 'admin') {
                          $href = route('hiringportal.index');
                      }
                  }
              @endphp
              @auth
              @if(auth()->user()->role == 'hr' || auth()->user()->role == 'admin')
              <li class="sidebar-item">
                  <a class="sidebar-link justify-content-between"  
                  href="{{ $href }}">
                    <div class="d-flex align-items-center gap-3">
                      <span class="d-flex">
                        <i class="bi bi-globe"></i>
                      </span>
                      <span class="hide-menu">Hiring Portal</span>
                    </div>
                  </a>
              </li>
              @endif
             @endauth
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <script>
      jQuery(document).ready(function(){
        jQuery('.employeeHit').on('click', function(){
            window.location.href = jQuery('.employeelistHit').attr('href');
        });
      });
    </script>