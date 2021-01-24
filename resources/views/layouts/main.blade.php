    <!DOCTYPE html>
    <html lang="en">
    @include('layouts.head')

    <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
        <div class="site-wrap">
            <div class="site-mobile-menu site-navbar-target">
                <div class="site-mobile-menu-header">
                    <div class="site-mobile-menu-close mt-3">
                        <span class="icon-close2 js-menu-toggle"></span>
                    </div>
                </div>
                <div class="site-mobile-menu-body"></div>
            </div>
            @include('layouts.header')
        @yield('body')
        @include('layouts.footer')
    </div>
    @include('layouts.scripts')
</body>

</html>