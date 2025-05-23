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

    <title>Berita & Artikel | {{ $article->title }}</title>
@endsection

<x-layouts.main>
    <!-- Hero Section -->
    <x-hero-section :title="$heroSection->title" :image="$heroSection->image" />

    <!-- Article Detail Section yang Responsif -->
    <section class="py-12 md:py-20 bg-white">
        <div class="container mx-auto px-4">

            <!-- Section Header -->
            <div class="max-w-7xl mx-auto text-center mb-6 md:mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl text-primary-500 font-bold mb-4">{{ $article->title }}</h2>
            </div>

            <!-- Featured Article Image Responsif -->
            <div class="flex justify-center mb-6 md:mb-8">
                <div class="relative w-full max-w-[1000px] h-[250px] sm:h-[350px] md:h-[400px] lg:h-[476px]">
                    <!-- Gambar Artikel -->
                    <img src="{{ Storage::url('articles/' . $article->image) }}"
                         alt="{{ $article->title }}" class="w-full h-full object-cover rounded-lg">

                    <!-- Badge Kategori -->
                    <div class="absolute top-4 left-4 bg-primary-500 z-10 text-white text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $article->category->title }}
                    </div>
                </div>
            </div>

            <!-- Article Content dengan Styling yang Lebih Baik -->
            <div class="max-w-4xl mx-auto">
                <div class="prose prose-sm sm:prose md:prose-lg mx-auto">
                    {!! $article->content !!}
                </div>
            </div>

        </div>
    </section>

    <!-- Related Articles Section yang Responsif -->
    <section class="py-12 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4">

            <div class="max-w-3xl mx-auto text-center mb-8">
                <h3 class="text-xl sm:text-2xl md:text-3xl text-primary-500 font-bold mb-2">Artikel Terkait</h3>
            </div>

            <!-- Slider News & Article dengan Navigasi yang Jelas -->
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

                <!-- Navigation Buttons yang Jelas -->
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
</x-layouts.main>
