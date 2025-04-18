{{-- resources/views/layouts/admin/header.blade.php --}}
<header class="main-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <button type="button" id="sidebar-toggle" class="btn d-lg-none">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <span class="ms-2 fs-5 fw-semibold d-none d-lg-inline">
                    @yield('page-title', 'Dashboard')
                </span>
            </div>
            
            <div class="col-auto d-flex align-items-center">
                <!-- Search -->
                <div class="position-relative me-3 d-none d-md-block">
                    <input type="text" class="form-control" placeholder="Search...">
                    <i class="bi bi-search position-absolute" style="top: 10px; left: 10px;"></i>
                </div>
                
                <!-- Notifications -->
                <div class="dropdown me-3">
                    <button class="btn position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell fs-5"></i>
                        @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                            <span class="notification-badge"></span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border" style="width: 300px;">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        
                        @if(isset($notifications) && count($notifications) > 0)
                            @foreach($notifications as $notification)
                                <li>
                                    <a href="#" class="dropdown-item notification-item {{ $notification->read_at ? '' : 'unread' }}">
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium">{{ $notification->data['message'] }}</span>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li><div class="dropdown-item">No notifications</div></li>
                        @endif
                        
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a href="#" class="dropdown-item text-center text-primary">View all notifications</a>
                        </li>
                    </ul>
                </div>
                
                <!-- Profile -->
                <div class="dropdown profile-menu">
                    <button class="btn d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-pic me-2">
                            @if(isset(Auth::user()->profile_photo_path))
                                <img src="#" alt="User" class="rounded-circle" width="35" height="35">
                            @else
                                <i class="bi bi-person"></i>
                            @endif
                        </div>
                        <span class="d-none d-md-block me-1">Admin User</span>
                        <i class="bi bi-chevron-down d-none d-md-block"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border">
                        <li><a class="dropdown-item" href="#">Your Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="#">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>