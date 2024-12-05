<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="nord">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Notifku') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" x-data="{ isOpen: true }">
    <div class="min-h-screen flex">
        <div class="hidden lg:block w-65 bg-gradient-to-b from-blue-500 to-green-600 text-white p-4 min-h-screen">
            <!-- Sidebar -->
            @include('layouts.sidebar')
        </div>
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header>
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Main content area -->
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white text-center py-4 border-t">
                <div class="container mx-auto">
                    <p class="text-gray-600">© 2025 - suga - 
                        <a class="link link-info" href="https://bprku.com" target="blank">bprku.com</a></p>
                </div>
            </footer>
        </div>

    </div>

</body>
<script>
    function toggleSidebar() {
        this.isOpen = !this.isOpen;
    }
</script>

</html>
