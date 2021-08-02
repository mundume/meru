<div class="horizontal-menu">
    <nav class="navbar top-navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="{{ route('dashboard.index') }}" class="navbar-brand">
artists<span>APP</span>
                </a>
                <form class="search-form">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i data-feather="search"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
                    </div>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#" class="nav-item">
                            <i data-feather="dollar-sign"></i>
                            <span style="color:orange;margin-top:-10px;" id="check_balance">0.00</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown nav-notifications">
                        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i data-feather="bell"></i>
                            <div class="indicator">
                                <div class="circle"></div>
                            </div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <p class="mb-0 font-weight-medium">1 New Notifications</p>
                                <a href="javascript:;" class="text-muted">Clear all</a>
                            </div>
                            <div class="dropdown-body">
                                <a href="javascript:;" class="dropdown-item">
                                    <div class="icon">
                                        <i data-feather="alert-circle"></i>
                                    </div>
                                    <div class="content">
                                        <p>New book!</p>
                                        <p class="sub-text text-muted">1 hrs ago</p>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer d-flex align-items-center justify-content-center">
                                <a href="javascript:;">View all</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown nav-profile">
                        <a class="nav-link dropdown-toggle" href="dashboard-one.html#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<img src="{{asset('shuttle_images/new_.png')}}" alt="profile">
                        </a>
                        <div class="dropdown-menu" aria-labelledby="profileDropdown">
                            <div class="dropdown-header d-flex flex-column align-items-center">
                                <div class="figure mb-3">
<img src="{{asset('shuttle_images/new_.png')}}" alt="logo">
                                </div>
                                <div class="info text-center">
                                    <p class="name font-weight-bold mb-0">
                                        {{auth()->user()->fname ." ". auth()->user()->lname}}
                                    </p>
                                    <p class="email text-muted mb-3">{{auth()->user()->email}}</p>
                                </div>
                            </div>
                            <div class="dropdown-body">
                                <ul class="profile-nav p-0 pt-3">
                                    @if(auth()->user()->can('admin-show'))
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.calendarial') }}" class="nav-link">
                                            <i data-feather="edit-3"></i>
                                            <span>Peak & Off-peak</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.agents') }}" class="nav-link">
                                            <i data-feather="plus"></i>
                                            <span>Add Agent</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.add_fleets') }}" class="nav-link">
                                            <i data-feather="truck"></i>
                                            <span>Add Fleet</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.settings') }}" class="nav-link">
                                            <i data-feather="settings"></i>
                                            <span>Office Settings</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.sms_blasts') }}" class="nav-link">
                                            <i data-feather="message-square"></i>
                                            <span>Sms Blasts</span>
                                        </a>
                                        </li>
                                        @endif
                                        <li class="nav-item">
                                        <a href="{{ route('dashboard.edit_account') }}" class="nav-link">
                                            <i data-feather="edit"></i>
                                            <span>Edit Profile</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('logout') }}" class="nav-link" style="color:red;" onclick="event.preventDefault();
                                                                      document.getElementById('logout-form').submit();">
                                            <i data-feather="log-out"></i>
                                            <span>Log Out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                    <i data-feather="menu"></i>
                </button>
            </div>
        </div>
    </nav>
    <nav class="bottom-navbar">
        <div class="container">
            <ul class="nav page-navigation">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.index') }}">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                @if(auth()->user()->can('admin-show'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="map-pin"></i>
                        <span class="menu-title">Routes</span>
                        <i class="link-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.add_route') }}">
                                    <span class="menu-title">
                                        Add Route
                                    </span>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('dashboard.routes') }}">
                                            <span class="menu-title">
                                                All Route
                                            </span>
                                        </a>
                                    </li>
                        </ul>
                    </div>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.add_parcel') }}">
                        <i class="link-icon" data-feather="folder-plus"></i>
                        <span class="menu-title">Add Parcel</span>
                    </a>
                </li>
                @if(auth()->user()->can('admin-show'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.parcels') }}">
                        <i class="link-icon" data-feather="map"></i>
                        <span class="menu-title">Parcel Dispatches</span>
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.agent_parcels') }}">
                        <i class="link-icon" data-feather="map"></i>
                        <span class="menu-title">Parcel Dispatches</span>
                    </a>
                    </li>
                    @endif
                    @if(auth()->user()->can('admin-show'))
                    <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.dispatches') }}">
                        <i class="link-icon" data-feather="truck"></i>
                        <span class="menu-title">Fleet Dispatches</span>
                    </a>
                </li>
{{-- <li class="nav-item">
                    <a href="{{ route('dashboard.wallet') }}" class="nav-link">
                        <i class="link-icon" data-feather="dollar-sign"></i>
                        <span class="menu-title">Wallet</span></a>
</li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.bookings') }}">
                        <i class="link-icon" data-feather="globe"></i>
                        <span class="menu-title">Bookings</span></a>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="globe"></i>
                        <span class="menu-title">Bookings</span>
                        <i class="link-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.bookings') }}">
                                    <span class="menu-title">
                                        Bookings
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.future_bookings') }}">
                                    <span class="menu-title">
                                        Future Bookings
                                    </span>
                                </a>
                            </li>
<li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.wallet') }}">
                                    <span class="menu-title">
                                        Payments
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if(auth()->user()->hasRole('booking'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('agent.bookings') }}">
                        <i class="link-icon" data-feather="globe"></i>
                        <span class="menu-title">Bookings</span></a>
                    </a>
                </li>
                @endif
                @if(auth()->user()->role_id == 1)
                <li class="nav-item">
                    <a href="{{ route('dashboard.daily_reporting') }}" class="nav-link">
<i class="link-icon" data-feather="activity"></i>
                        <span class="menu-title">Reporting</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</div>