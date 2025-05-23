<!--- Dashboard --->
<li class="menu-divider">
    <span class="menu-title">Main</span>
</li>
<li>
    <a class="menu" href="{{ route('admin.dashboard') }}">
        <span>
            <img class="menu-icon" src="{{ asset('assets/icons-admin/dashboard.svg') }}" alt="icon" loading="lazy" />
            Dashboard
        </span>
    </a>
</li>

<!--- Categories --->
<li class="menu-divider">
    <span class="menu-title">Product Management</span>
</li>
<li>
    <a class="menu" data-bs-toggle="collapse" href="#categoryMenu">
        <span>
            <img class="menu-icon" src="{{ asset('assets/icons-admin/category.svg') }}" alt="icon" loading="lazy" />
            Categories
        </span>
        <img src="{{ asset('assets/icons-admin/caret-down.svg') }}" alt="icon" class="downIcon">
    </a>
    <div class="dropdownMenuCollapse collapse" id="categoryMenu">
        <div class="listBar">
            <a href="{{ route('admin.categories.index') }}" class="subMenu {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                Category
            </a>
            <a href="{{ route('admin.categories.create') }}" class="subMenu {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">
                Add Category
            </a>
        </div>
    </div>
</li>

<!--- Blog --->
<li class="menu-divider">
    <span class="menu-title">Marketing Promotions</span>
</li>
<li>
    <a class="menu" data-bs-toggle="collapse" href="#blogMenu">
        <span>
            <img class="menu-icon" src="{{ asset('assets/icons-admin/ads.svg') }}" alt="icon" loading="lazy" />
            Blogs
        </span>
        <img src="{{ asset('assets/icons-admin/caret-down.svg') }}" alt="icon" class="downIcon">
    </a>
    <div class="dropdownMenuCollapse collapse" id="blogMenu">
        <div class="listBar">
            <a href="{{ route('admin.articles.index') }}" class="subMenu {{ request()->routeIs('admin.articles.index') ? 'active' : '' }}">
                Articles
            </a>
            <a href="{{ route('admin.articles.create') }}" class="subMenu {{ request()->routeIs('admin.articles.create') ? 'active' : '' }}">
                Add Article
            </a>
        </div>
    </div>
</li>

<!--- Business Settings --->
<li class="menu-divider">
    <span class="menu-title">Business Administration</span>
</li>
<li>
    <a class="menu" data-bs-toggle="collapse" href="#settings">
        <span>
            <img class="menu-icon" src="{{ asset('assets/icons-admin/settings.svg') }}" alt="icon" loading="lazy" />
            Business Settings
        </span>
        <img src="{{ asset('assets/icons-admin/caret-down.svg') }}" alt="" class="downIcon">
    </a>
    <div class="dropdownMenuCollapse collapse" id="settings">
        <div class="listBar">
            <a href="#" class="subMenu">
                General Settings
            </a>
            <a href="#" class="subMenu">
                Business Setup
            </a>
            <a href="#" class="subMenu">
                Theme Colors
            </a>
            <a href="#" class="subMenu">
                Social Links
            </a>
        </div>
    </div>
</li>

<!--- Logout --->
<li>
    <a href="javascript:void(0)" class="menu logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span>
            <img class="menu-icon" src="{{ asset('assets/icons-admin/log-out.svg') }}" alt="icon" loading="lazy" />
            Logout Account
        </span>
    </a>
</li>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>