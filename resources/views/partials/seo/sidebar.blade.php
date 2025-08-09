<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/logo/lnvidiatech.png') }}" class="logo-icon" alt="logo icon">
        </div>
        @auth('seo')
        <div>
            <h4 class="logo-text">{{ Auth::guard('seo')->user()->name }}</h4>
        </div>
        @endauth

        <div class="toggle-icon ms-auto">
            <i class="bx bx-arrow-to-left text-black"></i>
        </div>
    </div>

    <ul class="metismenu" id="menu">
        <!-- Dashboard -->
        <li class="{{ request()->routeIs('seo.dashboard') ? 'mm-active' : '' }}">
            <a href="{{ route('seo.dashboard') }}" style="background-color: #044168; color:white">
                <div class="parent-icon">
                    <i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <!-- Pages Management -->
        @can('View Pages', auth('seo')->user())
        <li class=" {{ request()->routeIs('seo.pages.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class="bx bx-file-blank"></i>
                </div>
                <div class="menu-title">Pages</div>
            </a>
            <ul class="mm-collapse {{ request()->routeIs('seo.pages.*') ? 'mm-show' : '' }}">
                @can('View Pages', auth('seo')->user())
                <li><a href="{{ route('seo.pages.index') }}"><i class="bx bx-right-arrow-alt"></i>All Pages</a></li>
                @endcan
                @can('Create Pages', auth('seo')->user())
                <li><a href="{{ route('seo.pages.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New Page</a></li>
                @endcan
            </ul>
        </li>
        @endcan

        <!-- Blogs Management -->
        @can('View Blogs', auth('seo')->user())
        <li class="" class="{{ request()->routeIs('seo.blogs.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class="bx bx-edit"></i>
                </div>
                <div class="menu-title">Blogs</div>
            </a>
            <ul class="mm-collapse {{ request()->routeIs('seo.blogs.*') ? 'mm-show' : '' }}">
                @can('View Blogs', auth('seo')->user())
                <li><a href="{{ route('seo.blogs.index') }}"><i class="bx bx-right-arrow-alt"></i>All Blogs</a></li>
                @endcan
                @can('Create Blogs', auth('seo')->user())
                <li><a href="{{ route('seo.blogs.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New Blog</a></li>
                @endcan
            </ul>
        </li>
        @endcan
        <!-- Collections Management -->
         <li>
    <a href="#" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-category"></i></div>
        <div class="menu-title">Categories</div>
    </a>
    <ul>
        <li><a href="{{ route('seo.categories.index') }}"><i class="bx bx-right-arrow-alt"></i>All Categories</a></li>
         <li><a href="{{ route('seo.categories.create') }}"><i class="bx bx-right-arrow-alt"></i>Add Category</a></li>
     </ul>
</li>
 
       <!-- Schema Markup -->
@can('View Schema Markup', auth('seo')->user())
<li class="{{ request()->routeIs('seo.schema.*') ? 'mm-active' : '' }}">
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon">
            <i class="bx bx-file-blank"></i>
        </div>
        <div class="menu-title">Schema</div>
    </a>
    <ul class="mm-collapse {{ request()->routeIs('seo.schema.*') ? 'mm-show' : '' }}">
        @can('View Schema Markup', auth('seo')->user())
        <li>
            <a href="{{ route('seo.schema.index') }}">
                <i class="bx bx-code-alt"></i> Schema Markup
            </a>
        </li>
        @endcan

        @can('Create Schema Markup', auth('seo')->user())
        <li>
            <a href="{{ route('seo.schema.create') }}">
                <i class="bx bx-plus"></i> Create Schema
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan
      <!-- Sitemap Dropdown -->
@can('View Sitemap', auth('seo')->user())
<li class="has-arrow {{ request()->routeIs('seo.sitemap.*') ? 'mm-active' : '' }}">
    <a href="javascript:void(0);">
        <div class="parent-icon">
            <i class="bx bx-sitemap"></i>
        </div>
        <div class="menu-title">Sitemap</div>
    </a>
    <ul class="{{ request()->routeIs('seo.sitemap.*') ? 'mm-show' : '' }}">
        <li class="{{ request()->routeIs('seo.sitemap.index') ? 'active' : '' }}">
            <a href="{{ route('seo.sitemap.index') }}">
                <i class="bx bx-right-arrow-alt"></i>View Sitemaps
            </a>
        </li>
        <li class="{{ request()->routeIs('seo.sitemap.create') ? 'active' : '' }}">
            <a href="{{ route('seo.sitemap.create') }}">
                <i class="bx bx-right-arrow-alt"></i>Create Sitemap
            </a>
        </li>
    </ul>
</li>
@endcan


        <!-- Robots.txt -->
        @can('View Robots', auth('seo')->user())
        <li class="d-none" class="{{ request()->routeIs('seo.robots.*') ? 'mm-active' : '' }}">
            <a href="{{ route('seo.robots.index') }}">
                <div class="parent-icon">
                    <i class="bx bx-bot"></i>
                </div>
                <div class="menu-title">Robots.txt</div>
            </a>
        </li>
        @endcan

        <!-- Redirect Manager -->
        @can('View Redirect Manager', auth('seo')->user())
        <li class="d-none" class="{{ request()->routeIs('seo.redirects.*') ? 'mm-active' : '' }}">
            <a href="{{ route('seo.redirects.index') }}">
                <div class="parent-icon">
                    <i class="bx bx-transfer"></i>
                </div>
                <div class="menu-title">Redirect Manager</div>
            </a>
        </li>
        @endcan

        <!-- 404 Suggestions -->
        @can('View 404 Suggestion', auth('seo')->user())
        <li class="d-none" class="{{ request()->routeIs('seo.suggestions.*') ? 'mm-active' : '' }}">
            <a href="{{ route('seo.suggestions.index') }}">
                <div class="parent-icon">
                    <i class="bx bx-error-alt"></i>
                </div>
                <div class="menu-title">404 Suggestions</div>
            </a>
        </li>
        @endcan

        <!-- Google Merchant Center -->
        @can('seo view analytics', auth('seo')->user())
        <li class="d-none" class="{{ request()->routeIs('seo.merchant.*') ? 'mm-active' : '' }}">
            <a href="{{ route('seo.merchant.index') }}">
                <div class="parent-icon">
                    <i class="bx bxl-google"></i>
                </div>
                <div class="menu-title">Google Merchant Center</div>
            </a>
        </li>
        @endcan

        <!-- Divider -->
        <li class="menu-label d-none">User's Basic Settings</li>

        <!-- Team Management -->
        @can('seo manage team', auth('seo')->user())
        <li class="d-none" class="{{ request()->routeIs('seo.team.*') ? 'mm-active' : '' }}">
            <a href="{{ route('seo.team.index') }}">
                <div class="parent-icon">
                    <i class="bx bx-user-plus"></i>
                </div>
                <div class="menu-title">Create SEO Team Member</div>
            </a>
        </li>
        @endcan

        <!-- Profile Settings -->
        <li class="d-none" class="{{ request()->routeIs('seo.profile.*') ? 'mm-active' : '' }}">
            <a href="{{ route('seo.profile.edit') }}">
                <div class="parent-icon">
                    <i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Profile Setting</div>
            </a>
        </li>
    </ul>
</div>
