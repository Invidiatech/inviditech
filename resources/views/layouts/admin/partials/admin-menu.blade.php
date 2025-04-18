<!--- Dashboard --->
<li class="menu-divider">
    <span class="menu-title">Main</span>
</li>
<li>
    <a class="menu" href="#">
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
            <a href="#" class="subMenu">
                Category
            </a>
            <a href="#" class="subMenu">
                Sub Category
            </a>
            <a href="#" class="subMenu">
                Sub Sub Category
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
            <a href="{{ route('admin.articles.index') }}" class="subMenu">
                Article
            </a>
            <!-- Add more submenu items here if needed -->
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
    <a href="javascript:void(0)" class="menu logout">
        <span>
            <img class="menu-icon" src="{{ asset('assets/icons-admin/log-out.svg') }}" alt="icon" loading="lazy" />
            Logout Account
        </span>
    </a>
</li>
