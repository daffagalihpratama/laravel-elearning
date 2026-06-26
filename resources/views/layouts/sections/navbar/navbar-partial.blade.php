@php
use Illuminate\Support\Facades\Auth;
@endphp

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

    <!-- SEARCH -->
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="icon-base bx bx-search icon-md"></i>
            <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2" placeholder="Search...">
        </div>
    </div>

    <ul class="navbar-nav flex-row align-items-center ms-auto">

        <!-- USER DROPDOWN -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">

            <!-- AVATAR -->
            <a class="nav-link dropdown-toggle hide-arrow p-0"
               href="#"
               role="button"
               data-bs-toggle="dropdown">

                <div class="avatar avatar-online">
                    @auth
                        <img src="{{ Auth::user()->photo
                            ? asset('uploads/' . Auth::user()->photo)
                            : asset('assets/img/avatars/1.png') }}"
                             class="rounded-circle"
                             style="width:40px; height:40px; object-fit: cover;">
                    @endauth
                </div>
            </a>

            <!-- DROPDOWN MENU -->
            <ul class="dropdown-menu dropdown-menu-end">

                <!-- USER INFO -->
                <li>
                    <div class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    @auth
                                        <img src="{{ Auth::user()->photo
                                            ? asset('uploads/' . Auth::user()->photo)
                                            : asset('assets/img/avatars/1.png') }}"
                                             class="rounded-circle"
                                             style="width:40px; height:40px; object-fit: cover;">
                                    @endauth
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ Auth::user()->name ?? '-' }}</h6>
                                <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                            </div>
                        </div>
                    </div>
                </li>

                <li><div class="dropdown-divider"></div></li>

                <!-- MY PROFILE -->
                <li>
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="bx bx-user me-2"></i>
                        <span>My Profile</span>
                    </a>
                </li>

                <!-- SETTINGS -->
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span>Settings</span>
                    </a>
                </li>

                <li><div class="dropdown-divider"></div></li>

                <!-- LOGOUT -->
                <li>
                    <a class="dropdown-item"
                       href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off me-2"></i>
                        <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </li>

    </ul>
</div>
