 <nav id="sidebar" class="sidebar">
    <div class="sidebar-header d-flex align-items-center">
        <div class="sidebar-logo">CP</div>
        <h5 class="mb-0">{{ config('app.name', 'Company') }}</h5>
        <button type="button" id="close-sidebar" class="btn-close d-block d-lg-none ms-auto"></button>
    </div>
    
    <ul class="nav flex-column px-3 pt-3">
        <li class="nav-item">
            <a href="#" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                <i class="bi bi-house me-2"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i>
                Users
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link {{ request()->is('admin/reports*') ? 'active' : '' }}">
                <i class="bi bi-file-text me-2"></i>
                Reports
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link {{ request()->is('admin/analytics*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart me-2"></i>
                Analytics
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                <i class="bi bi-gear me-2"></i>
                Settings
            </a>
        </li>
    </ul>
    
    <div class="sidebar-bottom">
        <form method="POST" action="#">
            @csrf
            <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                <i class="bi bi-box-arrow-right me-2"></i>
                Logout
            </button>
        </form>
    </div>
</nav>