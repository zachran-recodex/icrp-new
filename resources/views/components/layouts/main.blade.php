<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @yield('meta_tag')
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ $title ?? config('app.name') }}</title>

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">

            <div x-data="{ isExpanded: false, tentangOpen: false }" class="fixed inset-y-0 z-[99] flex bg-background-primary border-r border-white/20"
                 :class="{ 'w-64': isExpanded, 'w-16': !isExpanded }">

                <div class="flex flex-col flex-grow w-full">
                    <!-- Logo dan Judul -->
                    <div class="px-5 py-6 space-y-1">
                        <button @click="isExpanded = !isExpanded"
                                class="flex items-center space-x-3 hover:text-white/80 transition-colors duration-200">
                            <i class="fa-solid fa-bars text-white/60 w-6 h-6"></i>
                        </button>
                        <h1 x-show="isExpanded" x-transition:enter="transition-opacity duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition-opacity duration-300" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="text-white text-xl font-semibold leading-tight">
                            Indonesian<br>Conference<br>of Religion and<br>Peace
                        </h1>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 px-3 mt-3 space-y-1">
                        <!-- Beranda with tooltip -->
                        <div class="relative">
                            <a href="{{ route('beranda') }}" class="flex items-center space-x-3 px-3 py-2 text-white/60 hover:text-white rounded-lg transition-colors duration-200 peer">
                                <i class="fa-solid fa-house w-6 h-6"></i>
                                <span x-show="isExpanded" class="text-sm">Beranda</span>
                            </a>
                            <div x-show="!isExpanded" class="absolute top-1/2 left-full -translate-y-1/2 ml-4 z-10 whitespace-nowrap rounded-lg bg-background-primary px-2 py-1 text-center text-sm text-white opacity-0 transition-all ease-out peer-hover:opacity-100 peer-focus:opacity-100" role="tooltip">
                                Beranda
                            </div>
                        </div>

                        <!-- Tentang ICRP dengan Submenu and tooltip -->
                        <div class="space-y-1 relative">
                            <button @click="tentangOpen = !tentangOpen" class="flex items-center w-full px-3 py-2 text-white/60 hover:text-white rounded-lg transition-colors duration-200 peer">
                                <i class="fa-solid fa-circle-info w-6 h-6"></i>
                                <div x-show="isExpanded" class="flex items-center justify-between w-full ml-3">
                                    <span class="text-sm">Tentang ICRP</span>
                                    <i class="fa-solid" :class="tentangOpen ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                                </div>
                            </button>
                            <div x-show="!isExpanded" class="absolute top-1/2 left-full -translate-y-1/2 ml-4 z-10 whitespace-nowrap rounded-lg bg-background-primary px-2 py-1 text-center text-sm text-white opacity-0 transition-all ease-out peer-hover:opacity-100 peer-focus:opacity-100" role="tooltip">
                                Tentang ICRP
                            </div>

                            <div x-show="isExpanded && tentangOpen" class="pl-11 space-y-1">
                                <a href="{{ route('tentang') }}" class="block py-2 text-sm text-white/60 hover:text-white transition-colors duration-200">Tentang Kami</a>
                                <a href="{{ route('pendiri') }}" class="block py-2 text-sm text-white/60 hover:text-white transition-colors duration-200">Profil Pendiri ICRP</a>
                                <a href="{{ route('pengurus') }}" class="block py-2 text-sm text-white/60 hover:text-white transition-colors duration-200">Pengurus ICRP</a>
                                <a href="{{ route('kontak') }}" class="block py-2 text-sm text-white/60 hover:text-white transition-colors duration-200">Kontak Kami</a>
                            </div>
                        </div>

                        <!-- Sahabat ICRP with tooltip -->
                        <div class="relative">
                            <a href="{{ route('sahabat') }}" class="flex items-center space-x-3 px-3 py-2 text-white/60 hover:text-white rounded-lg transition-colors duration-200 peer">
                                <i class="fa-solid fa-users w-6 h-6"></i>
                                <span x-show="isExpanded" class="text-sm">Sahabat ICRP</span>
                            </a>
                            <div x-show="!isExpanded" class="absolute top-1/2 left-full -translate-y-1/2 ml-4 z-10 whitespace-nowrap rounded-lg bg-background-primary px-2 py-1 text-center text-sm text-white opacity-0 transition-all ease-out peer-hover:opacity-100 peer-focus:opacity-100" role="tooltip">
                                Sahabat ICRP
                            </div>
                        </div>

                        <!-- Jaringan with tooltip -->
                        <div class="relative">
                            <a href="{{ route('jaringan') }}" class="flex items-center space-x-3 px-3 py-2 text-white/60 hover:text-white rounded-lg transition-colors duration-200 peer">
                                <i class="fa-solid fa-network-wired w-6 h-6"></i>
                                <span x-show="isExpanded" class="text-sm">Jaringan</span>
                            </a>
                            <div x-show="!isExpanded" class="absolute top-1/2 left-full -translate-y-1/2 ml-4 z-10 whitespace-nowrap rounded-lg bg-background-primary px-2 py-1 text-center text-sm text-white opacity-0 transition-all ease-out peer-hover:opacity-100 peer-focus:opacity-100" role="tooltip">
                                Jaringan
                            </div>
                        </div>

                        <!-- Berita & Artikel with tooltip -->
                        <div class="relative">
                            <a href="{{ route('berita') }}" class="flex items-center space-x-3 px-3 py-2 text-white/60 hover:text-white rounded-lg transition-colors duration-200 peer">
                                <i class="fa-solid fa-newspaper w-6 h-6"></i>
                                <span x-show="isExpanded" class="text-sm">Berita & Artikel</span>
                            </a>
                            <div x-show="!isExpanded" class="absolute top-1/2 left-full -translate-y-1/2 ml-4 z-10 whitespace-nowrap rounded-lg bg-background-primary px-2 py-1 text-center text-sm text-white opacity-0 transition-all ease-out peer-hover:opacity-100 peer-focus:opacity-100" role="tooltip">
                                Berita & Artikel
                            </div>
                        </div>

                        <!-- Pustaka with tooltip -->
                        <div class="relative">
                            <a href="{{ route('pustaka') }}" class="flex items-center space-x-3 px-3 py-2 text-white/60 hover:text-white rounded-lg transition-colors duration-200 peer">
                                <i class="fa-solid fa-book w-6 h-6"></i>
                                <span x-show="isExpanded" class="text-sm">Pustaka</span>
                            </a>
                            <div x-show="!isExpanded" class="absolute top-1/2 left-full -translate-y-1/2 ml-4 z-10 whitespace-nowrap rounded-lg bg-background-primary px-2 py-1 text-center text-sm text-white opacity-0 transition-all ease-out peer-hover:opacity-100 peer-focus:opacity-100" role="tooltip">
                                Pustaka
                            </div>
                        </div>

                        <!-- Advokasi with tooltip -->
                        <div class="relative">
                            <a href="{{ route('advokasi') }}" class="flex items-center space-x-3 px-3 py-2 text-white/60 hover:text-white rounded-lg transition-colors duration-200 peer">
                                <i class="fa-solid fa-comment w-6 h-6"></i>
                                <span x-show="isExpanded" class="text-sm">Advokasi KBB</span>
                            </a>
                            <div x-show="!isExpanded" class="absolute top-1/2 left-full -translate-y-1/2 ml-4 z-10 whitespace-nowrap rounded-lg bg-background-primary px-2 py-1 text-center text-sm text-white opacity-0 transition-all ease-out peer-hover:opacity-100 peer-focus:opacity-100" role="tooltip">
                                Advokasi KBB
                            </div>
                        </div>
                    </nav>

                    <!-- Login / Register atau User Info -->
                    <div class="mt-auto px-3 py-4 border-t border-white/20">
                        @guest
                            <!-- Jika pengguna belum login -->
                            <div class="space-y-2">
                                <div class="relative">
                                    <a href="{{ route('login') }}" class="flex items-center space-x-3 px-3 py-2 text-white/60 hover:text-white rounded-lg transition-colors duration-200 peer">
                                        <i class="fa-solid fa-sign-in-alt w-6 h-6"></i>
                                        <span x-show="isExpanded" class="text-sm">Login</span>
                                    </a>
                                    <div x-show="!isExpanded" class="absolute top-1/2 left-full -translate-y-1/2 ml-4 z-10 whitespace-nowrap rounded-lg bg-background-primary px-2 py-1 text-center text-sm text-white opacity-0 transition-all ease-out peer-hover:opacity-100 peer-focus:opacity-100" role="tooltip">
                                        Login
                                    </div>
                                </div>
                                <div class="relative">
                                    <a href="{{ route('register') }}" class="flex items-center space-x-3 px-3 py-2 text-white/60 hover:text-white rounded-lg transition-colors duration-200 peer">
                                        <i class="fa-solid fa-user-plus w-6 h-6"></i>
                                        <span x-show="isExpanded" class="text-sm">Register</span>
                                    </a>
                                    <div x-show="!isExpanded" class="absolute top-1/2 left-full -translate-y-1/2 ml-4 z-10 whitespace-nowrap rounded-lg bg-background-primary px-2 py-1 text-center text-sm text-white opacity-0 transition-all ease-out peer-hover:opacity-100 peer-focus:opacity-100" role="tooltip">
                                        Register
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Jika pengguna sudah login -->
                            <div class="flex items-center justify-between px-3 py-2 text-white/60 rounded-lg">
                                <div x-show="isExpanded" class="flex items-center space-x-3">
                                    <i class="fa-solid fa-user w-6 h-6"></i>
                                    <span class="text-sm">{{ Auth::user()->name }}</span>
                                </div>
                                <div class="relative">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="text-white/60 hover:text-white transition-colors duration-200 peer">
                                            <i class="fa-solid fa-sign-out-alt w-6 h-6"></i>
                                        </button>
                                        <div x-show="!isExpanded" class="absolute top-1/2 left-full -translate-y-1/2 ml-4 z-10 whitespace-nowrap rounded-lg bg-background-primary px-2 py-1 text-center text-sm text-white opacity-0 transition-all ease-out peer-hover:opacity-100 peer-focus:opacity-100" role="tooltip">
                                            Logout
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="pl-16">
                <header class="pl-16 absolute top-0 right-0 left-0 bg-transparent z-50">
                    <div class="container mx-auto px-12 py-4">
                        <div class="flex items-center justify-center">
                            <img class="h-12" src="{{ asset('images/logo.png') }}" alt="Logo ICRP">
                        </div>
                    </div>
                </header>

                {{ $slot }}

                <!-- Footer -->
                <footer class="bg-background-primary text-white">
                    <!-- Main Footer -->
                    <div class="container mx-auto px-4 pt-16 pb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            <!-- Organization Info -->
                            <div class="space-y-4">
                                <img class="h-12" src="{{ asset('images/logo.png') }}" alt="Logo ICRP">
                                <p class="text-gray-400">
                                    Indonesian Conference on Religion and Peace (ICRP) adalah organisasi yang
                                    berdedikasi untuk membangun dialog antar agama dan mempromosikan perdamaian di
                                    Indonesia.
                                </p>
                                <div class="flex space-x-4">
                                    <a href="#" class="text-gray-400 hover:text-primary transition">
                                        <i class="fa-brands fa-facebook w-6 h-6"></i>
                                    </a>
                                    <a href="#" class="text-gray-400 hover:text-primary transition">
                                        <i class="fa-brands fa-linkedin w-6 h-6"></i>
                                    </a>
                                    <a href="#" class="text-gray-400 hover:text-primary transition">
                                        <i class="fa-brands fa-youtube w-6 h-6"></i>
                                    </a>
                                    <a href="#" class="text-gray-400 hover:text-primary transition">
                                        <i class="fa-brands fa-instagram w-6 h-6"></i>
                                    </a>
                                    <a href="#" class="text-gray-400 hover:text-primary transition">
                                        <i class="fa-brands fa-tiktok w-6 h-6"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Quick Links -->
                            <div>
                                <h4 class="text-lg font-semibold mb-6">Menu</h4>
                                <nav class="space-y-3">
                                    <a href="#"
                                       class="block text-gray-400 hover:text-primary transition">Beranda</a>
                                    <a href="#" class="block text-gray-400 hover:text-primary transition">Tentang
                                        ICRP</a>
                                    <a href="#" class="block text-gray-400 hover:text-primary transition">Sahabat
                                        ICRP</a>
                                    <a href="#"
                                       class="block text-gray-400 hover:text-primary transition">Jaringan</a>
                                    <a href="#" class="block text-gray-400 hover:text-primary transition">Berita
                                        & Artikel</a>
                                    <a href="#"
                                       class="block text-gray-400 hover:text-primary transition">Pustaka</a>
                                </nav>
                            </div>

                            <!-- Contact Info -->
                            <div>
                                <h4 class="text-lg font-semibold mb-6">Kontak</h4>
                                <div class="space-y-4">
                                    <a href="" class="flex items-start space-x-3">
                                        <i class="fa-solid fa-location-dot w-6 h-6 text-primary"></i>
                                        <span class="text-gray-400">
                                            Jl. Cempaka Putih Barat XXI No. 34<br>
                                            Jakarta Pusat 10520
                                        </span>
                                    </a>
                                    <a href="" class="flex items-center space-x-3">
                                        <i class="fa-solid fa-phone w-6 h-6 text-primary"></i>
                                        <span class="text-gray-400">(021) 42802349</span>
                                    </a>
                                    <a href="" class="flex items-center space-x-3">
                                        <i class="fa-solid fa-envelope w-6 h-6 text-primary"></i>
                                        <span class="text-gray-400">info@icrp.id</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Google Maps -->
                            <div>
                                <h4 class="text-lg font-semibold mb-6">Lokasi</h4>
                                <div class="w-full h-48 bg-gray-700 rounded-lg overflow-hidden">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.633068725179!2d106.8659217!3d-6.179844!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4ff60232a8b%3A0xc77634900d08328d!2sIndonesian%20Conference%20on%20Religion%20and%20Peace%20(ICRP)!5e0!3m2!1sid!2sid!4v1740990622369!5m2!1sid!2sid"
                                        width="100%"
                                        height="100%"
                                        style="border:0;"
                                        allowfullscreen=""
                                        loading="lazy"
                                        class="rounded-lg"
                                        title="Lokasi ICRP">
                                    </iframe>
                                </div>
                                <p class="text-gray-400 mt-3 text-sm">Kunjungi Rumah Perdamaian kami untuk informasi lebih lanjut.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Footer -->
                    <div class="border-t border-white/20">
                        <div class="container mx-auto px-4 py-6">
                            <div class="flex flex-col md:flex-row justify-between items-center">
                                <p class="text-gray-400 text-sm">
                                    © {{ date('Y') }} Indonesian Conference on Religion and Peace (ICRP). All rights reserved.
                                </p>
                                <div class="flex space-x-6 mt-4 md:mt-0">
                                    <a href="#" class="text-sm text-gray-400 hover:text-primary transition">Privacy
                                        Policy</a>
                                    <a href="#" class="text-sm text-gray-400 hover:text-primary transition">Terms of
                                        Service</a>
                                    <span class="text-sm text-gray-400">Created by <a href="https://recodex.id" target="_blank" class="text-[#86c332]">Recodex ID</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>

            </div>
        </div>

        @fluxScripts
    </body>
</html>
