@section('meta_tag')
    <meta name="description" content="{!! $library->description !!}">
    <meta name="keywords" content="{{ optional($pageSetups['pustaka'])->meta_keywords ?? '' }}">
    <meta name="author" content="RECODEX ID">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="{{ $library->title }} | {{ optional($pageSetups['pustaka'])->title ?? 'Pustaka' }}">
    <meta property="og:description" content="{!! $library->description !!}">
    <meta property="og:image" content="{{ Storage::url('libraries/' . $library->image) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $library->title }} | {{ optional($pageSetups['pustaka'])->title ?? 'Pustaka' }}">
    <meta name="twitter:description" content="{!! $library->description !!}">
    <meta name="twitter:image" content="{{ Storage::url('libraries/' . $library->image) }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <title>{{ $library->title }} | {{ optional($pageSetups['pustaka'])->title ?? 'Pustaka' }}</title>
@endsection

<x-main-layout>
    <!-- Hero Section -->
    <x-hero-section :title="$heroSection->title" :image="$heroSection->image" />

    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <!-- Grid Utama -->
            <div class="grid grid-cols-4 gap-20">
                <!-- Kolom Konten Utama (3/4 Lebar) -->
                <div class="col-span-3">
                    <!-- Tombol Back -->
                    <div class="mb-8">
                        <a href="{{ route('pustaka') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-full text-gray-800 transition duration-300 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Pustaka
                        </a>
                    </div>

                    <!-- Detail Buku -->
                    <div class="grid grid-cols-3 gap-8">
                        <!-- Gambar Buku -->
                        <div class="flex w-full bg-gray-200 py-8 rounded-lg justify-center">
                            <img src="{{ asset('images/book.png') }}" alt="" class="w-[281px] h-[333px] object-cover rounded-lg">
                        </div>

                        <!-- Informasi Buku -->
                        <div class="col-span-2 space-y-8">
                            <h2 class="text-2xl text-primary-500 font-bold mb-4">{{ $library->title }}</h2>
                            <div class="grid grid-cols-2">
                                <ul>
                                    <li>Bahasa :</li>
                                    <li>Penulis :</li>
                                    <li>Penerbit :</li>
                                </ul>
                                <ul>
                                    <li>Tanggal Rilis :</li>
                                    <li>Halaman :</li>
                                    <li>Format :</li>
                                </ul>
                            </div>
                            <h2 class="text-xl text-primary-500 font-bold mb-4">Deskripsi Buku</h2>
                            <p class="text-gray-600">
                                Djohan Effendi adalah salah satu sosok penting dalam upaya pengembangan kehidupan keagamaan yang lebih dialogis, harmonis, dan toleran dalam era Indonesia modern. Kehidupan keagamaan-baik intra maupun antaragama- seperti itu tentu saja merupakan kebutuhan yang senantiasa harus diperjuangkan, bukan hanya untuk umat beragama itu sendiri, tapi juga untuk kepentingan keberlanjutan negara-bangsa Indonesia Kesediaan pak Djohan ikut berjuang menegakkan hak-hak kebebasan beragama di Indonesia tidaklah setengah-setengah melainkan all-out. Ini dilakukan beliau sejak jaman Orde Baru, hingga sekarang.
                            </p>
                        </div>
                    </div>

                    <!-- Review Buku -->
                    <h2 class="text-2xl text-primary-500 font-bold mb-4 mt-8">Review Buku</h2>
                    <p class="text-gray-600">
                        Djohan Effendi adalah salah satu sosok penting dalam upaya pengembangan kehidupan keagamaan yang lebih dialogis, harmonis, dan toleran dalam era Indonesia modern. Kehidupan keagamaan-baik intra maupun antaragama- seperti itu tentu saja merupakan kebutuhan yang senantiasa harus diperjuangkan, bukan hanya untuk umat beragama itu sendiri, tapi juga untuk kepentingan keberlanjutan negara-bangsa Indonesia Kesediaan pak Djohan ikut berjuang menegakkan hak-hak kebebasan beragama di Indonesia tidaklah setengah-setengah melainkan all-out. Ini dilakukan beliau sejak jaman Orde Baru, hingga sekarang.
                    </p>

                    <!-- Komentar Buku -->
                    <div class="mt-8">
                        <livewire:library-comments :library_id="$library->id" />
                    </div>
                </div>

                <!-- Kolom Pustaka Lainnya (1/4 Lebar) -->
                <div class="p-6 bg-gray-200 rounded-lg">
                    <div class="space-y-4">
                        @foreach($libraries as $library)
                            <div class="bg-white rounded-lg overflow-hidden shadow-md transition hover:shadow-lg">
                                <!-- Gambar Buku -->
                                <div class="relative aspect-[3/4] overflow-hidden">
                                    <img src="{{ Storage::url('libraries/' . $library->image) }}" alt="{{ $library->title }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-4">
                                        <span class="text-xs text-white/80">Religious Studies</span>
                                    </div>
                                </div>

                                <!-- Informasi Buku -->
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold mb-1">{{ $library->title }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">Penulis: {{ $library->author }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">2023</span>
                                        <a href="{{ route('pustaka.detail', $library->slug) }}" class="text-primary hover:text-primary/80 font-medium text-xs">
                                            Baca Selengkapnya →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
