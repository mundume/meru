<!DOCTYPE html>
<html>
@include('layouts.head')

<body class="light-version">
    {{-- @include('layouts.header') --}}
    @yield('body')
    @include('layouts.footer')
</body>

</html>