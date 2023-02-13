<!doctype html>
<html lang="en">
<head>
    @include('layouts.head')
     <!-- lightgallery plugins -->
    
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
    <script src="{{ mix('js/app.js') }}">
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
        $('#datepicker1').datepicker({
            uiLibrary: 'bootstrap4'
        });
        
 
    @vite(['resources/css/app.css','resources/js/app.js'])
    

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="
https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.min.js
"></script>

    

</body>
</html>
