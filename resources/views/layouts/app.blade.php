<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
              @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 bg-gray-900">
            @include('layouts.navigation')
        
            <!-- Page Heading -->
            {{-- ★ ここから通知ゾーン (共通で1カ所) ★ --}}
        @if ($errors->any())
            <div class="bg-red-500 text-white px-4 py-2 text-sm text-center">
                入力内容に誤りがあります。もう一度確認してください。
            </div>
        @elseif (session('status'))
            <div class="bg-green-600 text-white px-4 py-2 text-sm text-center">
                {{ session('status') }}
            </div>
        @endif
                              <header class="text-gray-300 bg-gray-800 ">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header') {{-- optional page‑specific header --}}
                </div>
            </header>

                        <main class="py-8">
                <div class="text-white max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('content')  {{-- main page body --}}
                </div>
            </main>
        </div>
            

            <!-- Page Content -->

    </body>
</html>
