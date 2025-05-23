@section('meta_tag')
    <meta name="description" content="{{ optional($pageSetups['advokasi'])->meta_description ?? '' }}">
    <meta name="keywords" content="{{ optional($pageSetups['advokasi'])->meta_keywords ?? '' }}">
    <meta name="author" content="RECODEX ID">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="{{ optional($pageSetups['advokasi'])->title ?? 'Advokasi KBB' }}">
    <meta property="og:description" content="{{ optional($pageSetups['advokasi'])->meta_description ?? '' }}">
    <meta property="og:image" content="{{ isset($heroSection) && $heroSection->image ? Storage::url('hero/' . $heroSection->image) : asset('images/hero.jpeg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ optional($pageSetups['advokasi'])->title ?? 'Advokasi KBB' }}">
    <meta name="twitter:description" content="{{ optional($pageSetups['advokasi'])->meta_description ?? '' }}">
    <meta name="twitter:image" content="{{ isset($heroSection) && $heroSection->image ? Storage::url('hero/' . $heroSection->image) : asset('images/hero.jpeg') }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <title>{{ optional($pageSetups['advokasi'])->title ?? 'Advokasi KBB' }}</title>
@endsection

<x-main-layout>
    <!-- Hero Section -->
    <x-hero-section :title="$heroSection->title" :image="$heroSection->image" />

    <!-- News & Advocacys Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">

            <!-- Section Header -->
            <div class="max-w-3xl mx-auto text-center mb-8">
                <h2 class="text-3xl md:text-4xl text-primary-500 font-bold mb-4">Advokasi Kebebasan Beragama dan Berkeyakinan</h2>
                <p class="text-gray-600">
                </p>
            </div>

            <!-- Featured News & Advocacys - Perbaikan Responsif -->
            <div class="flex justify-center mb-8">
                <a href="{{ route('advokasi.detail', $featuredAdvocacy->slug) }}"
                   class="relative w-full max-w-[1000px] h-[300px] md:h-[400px] lg:h-[476px]">
                    <!-- Gambar Artikel -->
                    <img src="{{ Storage::url('advocacies/' . $featuredAdvocacy->image) }}"
                         alt="{{ $featuredAdvocacy->title }}" class="w-full h-full object-cover rounded-lg">

                    <!-- Overlay & Konten -->
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-end p-4 md:p-6 lg:p-8 rounded-lg">
                        <h2 class="text-white text-lg md:text-xl font-bold mb-2 md:mb-3">
                            {{ $featuredAdvocacy->title }}
                        </h2>
                        <p class="text-gray-300 text-sm md:text-base">
                            {{ Str::limit(strip_tags($featuredAdvocacy->content), 100, '...') }}
                        </p>
                    </div>
                </a>
            </div>

            <!-- Slider News & Advocacy - Dengan Tombol Navigasi -->
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
                        @foreach ($advocacies->chunk(3) as $chunkedAdvocacies)
                            <div class="w-full flex-none grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                                @foreach ($chunkedAdvocacies as $advocacy)
                                    <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                                        <div class="relative h-48 sm:h-56 md:h-64">
                                            <!-- Gambar Artikel -->
                                            <img src="{{ Storage::url('advocacies/' . $advocacy->image) }}"
                                                 alt="{{ $advocacy->title }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="p-4 md:p-6">
                                            <h4 class="text-lg md:text-xl font-semibold mb-2 md:mb-3">{{ $advocacy->title }}</h4>
                                            <p class="text-gray-600 text-sm md:text-base mb-3">
                                                {{ Str::limit(strip_tags($advocacy->content), 100, '...') }}
                                            </p>
                                            <a href="{{ route('advokasi.detail', $advocacy->slug) }}" class="text-primary hover:text-primary/80 font-medium text-sm">
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

</x-main-layout>
