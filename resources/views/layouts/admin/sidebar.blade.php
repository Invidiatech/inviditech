<div class="app-sidebar">
    <div class="scrollbar-sidebar">
        <div class="branding-logo">
            
            <a href="">
                <img src="{{ $generaleSetting?->logo ?? asset('assets/logo.png') }}" alt="logo" loading="lazy" />
            </a>
        </div>
        <div class="branding-logo-forMobile">
            <a href="{{ $generaleSetting?->logo ?? asset('assets/logo.png') }}"></a>
        </div>
        <div class="app-sidebar-inner">
            <ul class="vertical-nav-menu">
            @include('layouts.admin.partials.admin-menu')
                 
            </ul>
        </div>
        <div class="sideBarfooter">
            <button type="button" class="fullbtn hite-icon" onclick="toggleFullScreen(document.body)">
                <img src="{{ asset('assets/icons-admin/expand.svg') }}" alt="icon" loading="lazy" />
            </button>
            
                    <a href="" class="fullbtn hite-icon">
                    <img src="{{ asset('assets/icons-admin/settings.svg') }}" alt="icon" loading="lazy" />
                    </a>
                
                    <a href="" class="fullbtn hite-icon">
                        <img src="{{ asset('assets/icons-admin/user-circle.svg') }}" alt="">
                    </a>
                 
                    <a href="" class="fullbtn hite-icon">
                        <img src="{{ asset('assets/icons-admin/user-circle.svg') }}" alt="">
                    </a>
                

            <a href="javascript:void(0)" class="fullbtn hite-icon logout">
                <img src="{{ asset('assets/icons-admin/log-out.svg') }}" alt="icon" loading="lazy" />
            </a>
        </div>
    </div>
</div>
