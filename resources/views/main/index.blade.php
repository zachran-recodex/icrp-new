@section('meta_tag')
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="">

    <link rel="canonical" href="{{ url()->current() }}">

    <title>Beranda</title>
@endsection

<x-layouts.main>
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ Storage::url('hero/' . $heroSection->image) }}" alt="{{ $heroSection->title }}"
                class="w-full h-full object-cover">
            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <!-- Content Overlay -->
        <div class="container mx-auto px-4 relative z-20 text-center">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    {{ $heroSection->title }}
                </h1>
                <p class="text-lg text-white/90 mb-8">
                    {{ $heroSection->subtitle }}
                </p>
                <a href="{{ route('tentang') }}"
                    class="inline-block bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-lg text-lg font-semibold transition transform hover:scale-105">
                    Selengkapnya
                </a>
            </div>
        </div>
    </section>

    <!-- News & Articles Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">

            <!-- Section Header -->
            <div class="max-w-3xl mx-auto text-center mb-8">
                <h2 class="text-3xl md:text-4xl text-primary-500 font-bold mb-4">Berita & Artikel</h2>
                <p class="text-gray-600">
                    Jelajahi berita dan artikel yang membahas dialog lintas agama, perdamaian, serta inisiatif kolaboratif dalam membangun harmoni di Indonesia.
                </p>
            </div>

            @if($featuredArticle)
                <!-- Featured News & Articles -->
                <div class="flex justify-center mb-8">
                    <a href="{{ route('berita.detail', $featuredArticle->slug) }}"
                       class="relative w-full max-w-[1000px] h-[250px] sm:h-[350px] md:h-[400px] lg:h-[476px]">
                        <!-- Gambar Artikel -->
                        <img src="{{ Storage::url('articles/' . $featuredArticle->image) }}"
                             alt="{{ $featuredArticle->title }}" class="w-full h-full object-cover rounded-lg">

                        <!-- Badge Kategori -->
                        <div class="absolute top-4 left-4 bg-primary-500 z-10 text-white text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $featuredArticle->category->title }}
                        </div>

                        <!-- Overlay & Konten -->
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-end p-4 md:p-6 lg:p-8 rounded-lg">
                            <h2 class="text-white text-lg sm:text-xl font-bold mb-2 md:mb-3">
                                {{ $featuredArticle->title }}
                            </h2>
                            <p class="text-gray-300 text-sm md:text-base">
                                {{ Str::limit(strip_tags($featuredArticle->content), 100, '...') }}
                            </p>
                        </div>
                    </a>
                </div>
            @endif

            @if($articles->count() > 0)
                <!-- Slider News & Article -->
                <div x-data="{
                        currentIndex: 0,
                        totalSlides: 3,
                        next() {
                            this.currentIndex = (this.currentIndex + 1) % this.totalSlides;
                        },
                        prev() {
                            this.currentIndex = (this.currentIndex - 1 + this.totalSlides) % this.totalSlides;
                        },
                        goToSlide(index) {
                            this.currentIndex = index;
                        }
                    }" class="relative">
                    <div class="overflow-hidden">
                        <div class="pb-4 flex transition-transform duration-700 ease-in-out"
                             :style="'transform: translateX(-' + (currentIndex * 100) + '%)'">

                            <!-- Looping artikel -->
                            @foreach ($articles->chunk(3) as $chunkedArticles)
                                <div class="w-full flex-none grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                                    @foreach ($chunkedArticles as $article)
                                        <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                                            <div class="relative h-48 sm:h-56 md:h-64">
                                                <!-- Gambar Artikel -->
                                                <img src="{{ Storage::url('articles/' . $article->image) }}"
                                                     alt="News" class="w-full h-full object-cover">

                                                <!-- Badge Kategori -->
                                                <div class="absolute top-4 left-4 bg-primary-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                                    {{ $article->category->title }}
                                                </div>
                                            </div>
                                            <div class="p-4 md:p-6">
                                                <h4 class="text-lg md:text-xl font-semibold mb-2 md:mb-3">{{ $article->title }}</h4>
                                                <p class="text-gray-600 text-sm md:text-base mb-3">
                                                    {{ Str::limit(strip_tags($article->content), 100) }}
                                                </p>
                                                <a href="{{ route('berita.detail', $article->slug) }}" class="text-primary hover:text-primary/80 font-medium text-sm">
                                                    Baca Selengkapnya →
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <button @click="prev" class="absolute top-1/2 left-0 -translate-y-1/2 -ml-4 md:ml-0 bg-white/80 hover:bg-white text-primary w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="next" class="absolute top-1/2 right-0 -translate-y-1/2 -mr-4 md:mr-0 bg-white/80 hover:bg-white text-primary w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- Indicator Dots -->
                    <div class="absolute -bottom-5 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        <template x-for="(_, index) in totalSlides" :key="index">
                            <button @click="goToSlide(index)"
                                    :class="{
                                'w-3 h-3 rounded-full bg-primary': currentIndex === index,
                                'w-3 h-3 rounded-full bg-primary/50': currentIndex !== index
                            }"
                                    class="transition-colors duration-300"></button>
                        </template>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Events Section -->
    <section class="py-20 bg-primary-50">
        <div class="container mx-auto px-4">

            <!-- Section Header -->
            <div class="max-w-3xl mx-auto text-center mb-8">
                <h2 class="text-3xl md:text-4xl text-primary-500 font-bold mb-4">Agenda Mendatang</h2>
                <p class="text-gray-600">
                    Ikuti berbagai agenda dan diskusi bermakna yang mendorong dialog lintas agama, perdamaian, serta kerja sama dalam membangun harmoni di Indonesia.
                </p>
            </div>

            @if($events->count() > 0)
                <!-- Grid Events -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-8">
                    @foreach ($events as $event)
                        <div
                            x-data="{ openModal: false }"
                            class="bg-white rounded-xl overflow-hidden shadow-lg transition hover:shadow-xl cursor-pointer"
                        >
                            <!-- Event Card -->
                            <div @click="openModal = true">
                                <div class="relative">
                                    <img src="{{ Storage::url('events/' . $event->image) }}" alt="{{ $event->title }}"
                                        class="w-full h-40 sm:h-44 md:h-48 object-cover">
                                    <div class="absolute top-4 left-4 bg-primary text-white px-3 py-1 rounded-full text-xs md:text-sm">
                                        {{ $event->date->format('d F Y') }}
                                    </div>
                                    <div class="absolute top-4 right-4 bg-primary text-white px-3 py-1 rounded-full text-xs md:text-sm">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $event->time->format('H:i') }} WIB</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 md:p-6">
                                    <h3 class="text-lg md:text-xl font-semibold mb-2 md:mb-3">{{ $event->title }}</h3>
                                    <p class="text-gray-600 text-sm md:text-base">
                                        {{ Str::limit(strip_tags($event->description), 80) }}
                                    </p>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="truncate">{{ $event->location }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal for this event -->
                            <div
                                x-cloak
                                x-show="openModal"
                                x-transition.opacity.duration.200ms
                                x-trap.inert.noscroll="openModal"
                                @keydown.escape.window="openModal = false"
                                @click.self="openModal = false"
                                class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
                                role="dialog"
                                aria-modal="true"
                                :aria-labelledby="'eventModalTitle-{{ $event->id }}'"
                            >
                                <!-- Modal Dialog -->
                                <div
                                    x-show="openModal"
                                    x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
                                    x-transition:enter-start="opacity-0 scale-50"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    class="flex max-w-3xl flex-col gap-4 overflow-hidden rounded-xl border border-neutral-300 bg-white text-neutral-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300"
                                >
                                    <!-- Dialog Header -->
                                    <div class="flex items-center justify-between border-b border-neutral-300 bg-neutral-50/60 p-4 dark:border-neutral-700 dark:bg-neutral-950/20">
                                        <h3 id="eventModalTitle-{{ $event->id }}" class="font-semibold tracking-wide text-neutral-900 dark:text-white">{{ $event->title }}</h3>
                                        <button @click="openModal = false" aria-label="close modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Dialog Body -->
                                    <div class="p-6 max-h-[70vh] overflow-y-auto">
                                        <!-- Event Details -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Event Image -->
                                            <div>
                                                <img
                                                    src="{{ Storage::url('events/' . $event->image) }}"
                                                    alt="{{ $event->title }}"
                                                    class="w-full h-auto rounded-lg object-cover"
                                                >

                                                <!-- Event Info Cards -->
                                                <div class="mt-4 grid grid-cols-2 gap-3">
                                                    <div class="bg-neutral-50 p-3 rounded-lg border border-neutral-200">
                                                        <div class="flex items-center text-primary-500 mb-1">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span class="text-sm font-medium">Tanggal</span>
                                                        </div>
                                                        <p class="text-sm">{{ $event->date->format('d F Y') }}</p>
                                                    </div>

                                                    <div class="bg-neutral-50 p-3 rounded-lg border border-neutral-200">
                                                        <div class="flex items-center text-primary-500 mb-1">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span class="text-sm font-medium">Waktu</span>
                                                        </div>
                                                        <p class="text-sm">{{ $event->time->format('H:i') }} WIB</p>
                                                    </div>

                                                    <div class="bg-neutral-50 p-3 rounded-lg border border-neutral-200 col-span-2">
                                                        <div class="flex items-center text-primary-500 mb-1">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            </svg>
                                                            <span class="text-sm font-medium">Lokasi</span>
                                                        </div>
                                                        <p class="text-sm">{{ $event->location }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Event Description and Details -->
                                            <div class="space-y-4">
                                                <div>
                                                    <h4 class="text-lg font-semibold text-primary-500 mb-2">Deskripsi Acara</h4>
                                                    <div class="prose prose-sm max-w-none">
                                                        {!! $event->description !!}
                                                    </div>
                                                </div>

                                                @if($event->speakers)
                                                <div>
                                                    <h4 class="text-lg font-semibold text-primary-500 mb-2">Pembicara</h4>
                                                    <div class="prose prose-sm max-w-none">
                                                        {!! $event->speakers !!}
                                                    </div>
                                                </div>
                                                @endif

                                                @if($event->moderator)
                                                <div>
                                                    <h4 class="text-lg font-semibold text-primary-500 mb-2">Moderator</h4>
                                                    <p>{{ $event->moderator }}</p>
                                                </div>
                                                @endif

                                                @if($event->registration_link)
                                                <div class="pt-2">
                                                    <a
                                                        href="{{ $event->registration_link }}"
                                                        target="_blank"
                                                        class="inline-block bg-primary-500 hover:bg-primary-600 text-white font-medium py-2 px-4 rounded-lg transition"
                                                    >
                                                        Daftar Sekarang
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dialog Footer -->
                                    <div class="flex justify-end border-t border-neutral-300 bg-neutral-50/60 p-4 dark:border-neutral-700 dark:bg-neutral-950/20">
                                        <button
                                            @click="openModal = false"
                                            type="button"
                                            class="whitespace-nowrap rounded-lg bg-primary-500 hover:bg-primary-600 px-4 py-2 text-center text-sm font-medium tracking-wide text-white transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 active:opacity-100 active:outline-offset-0"
                                        >
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

    <!-- Libraries Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">

            <!-- Section Header -->
            <div class="max-w-3xl mx-auto text-center mb-8">
                <h2 class="text-3xl md:text-4xl text-primary-500 font-bold mb-4">Pustaka</h2>
                <p class="text-gray-600">
                    Eksplorasi koleksi buku-buku kami tentang dialog antar agama dan kerukunan umat beragama
                </p>
            </div>

            @if($libraries->count() > 0)
                <!-- Grid Libraries -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-8 mb-8">
                    @foreach($libraries as $library)
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg transition hover:shadow-xl">
                            <div class="relative aspect-[3/4] overflow-hidden">
                                <img src="{{ Storage::url('libraries/' . $library->image) }}" alt="{{ $library->title }}"
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6">
                                    <span class="text-xs md:text-sm text-white/80">Religious Studies</span>
                                </div>
                            </div>
                            <div class="p-4 md:p-6">
                                <h3 class="text-lg md:text-xl font-semibold mb-2">{{ $library->title }}</h3>
                                <p class="text-gray-600 text-sm md:text-base mb-4">Penulis: {{ $library->author }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs md:text-sm text-gray-500">2023</span>
                                    <a href="{{ route('pustaka.detail', $library->slug) }}" class="text-primary hover:text-primary/80 font-medium text-sm">
                                        Baca Selengkapnya →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- View All Button -->
            <div class="text-center">
                <a href="{{ route('pustaka') }}"
                    class="inline-block px-8 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition transform hover:scale-105">
                    Lihat Semua Buku
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <x-call-to-action
        :title="$callToAction->title"
        :subtitle="$callToAction->subtitle"
        :image="$callToAction->image"
        :button-text="$callToAction->button_text"
        :button-link="route('kontak')"
    />
</x-layouts.main>
