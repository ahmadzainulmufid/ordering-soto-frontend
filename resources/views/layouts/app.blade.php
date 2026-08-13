<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Soto Lamongan Joko Tingkir')</title>
    @include('includes.style')
</head>

<body class="bg-background text-on-background font-body-md">

    {{-- Panggil Navbar --}}
    @include('includes.navbar')

    {{-- Tempat Konten Utama --}}
    <main class="max-w-360 mx-auto overflow-x-hidden">
        @yield('content')
    </main>

    {{-- Panggil Footer --}}
    @include('includes.footer')

    {{-- Panggil script --}}
    @include('includes.script')
</body>

</html>
