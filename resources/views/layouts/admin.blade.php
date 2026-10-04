<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - Library Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

<div class="min-h-screen">

    @include('layouts.admin.sidebar')

    <div class="flex min-h-screen flex-col lg:pl-72">

        @include('layouts.admin.header')

        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
            @include('layouts.admin.flash')

            @yield('content')
        </main>

        @include('layouts.admin.footer')

    </div>

</div>

@include('layouts.admin.scripts')

@stack('scripts')

</body>
</html>