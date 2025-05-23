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

    <title>Pustaka</title>
@endsection

<x-layouts.main>
    <!-- Hero Section -->
    <x-hero-section :title="$heroSection->title" :image="$heroSection->image" />

    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">

            <!-- Section Header -->
            <div class="max-w-3xl mx-auto text-center mb-8">
                <h2 class="text-3xl md:text-4xl text-primary-500 font-bold mb-4">Pustaka</h2>
                <p class="text-gray-600">
                    Jelajahi koleksi pustaka kami yang mencakup berbagai topik seperti dialog lintas agama, perdamaian, dan inisiatif kolaboratif untuk membangun harmoni di Indonesia.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex w-full bg-gray-200 py-8 rounded-lg justify-center">
                    <img src="{{ asset('images/book.png') }}"
                         alt="" class="w-[281px] h-[333px] object-cover rounded-lg">
                </div>
                <div class="md:col-span-2 flex flex-col justify-center">
                    <h2 class="text-2xl font-bold mb-4">Sang Pelintas Batas: Biografi Djohan Effendi</h2>
                    <p class="text-gray-600">
                        Djohan Effendi adalah salah satu sosok penting dalam upaya pengembangan kehidupan keagamaan yang lebih dialogis, harmonis, dan toleran dalam era Indonesia modern. Kehidupan keagamaan-baik intra maupun antaragama- seperti itu tentu saja merupakan kebutuhan yang senantiasa harus diperjuangkan, bukan hanya untuk umat beragama itu sendiri, tapi juga untuk kepentingan keberlanjutan negara-bangsa Indonesia Kesediaan pak Djohan ikut berjuang menegakkan hak-hak kebebasan beragama di Indonesia tidaklah setengah-setengah melainkan all-out. Ini dilakukan beliau sejak jaman Orde Baru, hingga sekarang.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- Library Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">

            <!-- Section Header -->
            <div class="max-w-3xl mx-auto text-center mb-8">
                <h2 class="text-3xl md:text-4xl text-primary-500 font-bold mb-4">Kumpulan Pustaka</h2>
                <p class="text-gray-600">
                    Temukan artikel, buku, dan sumber daya lainnya yang dapat memperkaya pengetahuan dan pemahaman Anda.
                </p>
            </div>

            @if($libraries->count() > 0)
                <!-- Regular Collection -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    @foreach($libraries as $library)
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg transition hover:shadow-xl">
                            <div class="relative aspect-[3/4] overflow-hidden">
                                <img src="{{ Storage::url('libraries/' . $library->image) }}" alt="{{ $library->title }}"
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <span class="text-sm text-white/80">Religious Studies</span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2">{{ $library->title }}</h3>
                                <p class="text-gray-600 mb-4">Penulis: {{ $library->author }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">2023</span>
                                    <a href="{{ route('pustaka.detail', $library->slug) }}" class="text-primary hover:text-primary/80 font-medium text-sm">
                                        Baca Selengkapnya →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
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
