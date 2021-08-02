<!doctype html>
<html lang="en">
<head>
    @include('layouts.head')
</head>
<body id="homepage-4" data-spy="scroll" data-target="#mynavbar">
    <div class="loader"></div>
    @include('layouts.top_bar')
    <div class="header-absolute">
        @include('layouts.header')
    </div>
   @yield('body')
    @include('layouts.footer')
@yield('scripts')
    @include('layouts.scripts')
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
        $('#datepicker1').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
</body>
</html>