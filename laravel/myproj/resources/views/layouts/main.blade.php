@php
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My App')</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
     @stack('styles')
</head>
<body>

    {{-- Header --}}
    @include('layouts.header')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.footer')
    @stack('scripts')
    <div class="toast-container" id="toastContainer"></div>

    @if(session('toastMessage'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                showToast("{{ session('toastType') }}", "{{ session('toastMessage') }}");
            });
        </script>
        @php
            // Set session values to empty strings
            session(['toastMessage' => '']);
            session(['toastType' => '']);
        @endphp

    @endif

    <script src="{{ asset('js/toast.js') }}"></script>

</body>
</html>
