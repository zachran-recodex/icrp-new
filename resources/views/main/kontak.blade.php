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

    <title>Kontak Kami</title>
@endsection

<x-layouts.main>
    <!-- Hero Section -->
    <x-hero-section :title="$heroSection->title" :image="$heroSection->image" />

    <!-- Contact Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Alamat & Kontak -->
                <div>
                    <h3 class="text-lg font-semibold mb-2">Alamat :</h3>
                    <p class="font-bold text-primary">Rumah Perdamaian</p>
                    <p>Jl. Cempaka Putih Barat XXI No. 34<br>Jakarta Pusat 10520</p>

                    <p class="mt-4">Telp. 021-42802349<br>icrp.indonesia@gmail.com<br>info@icrp.id</p>

                    <!-- Sosial Media -->
                    <div class="mt-6 flex items-center gap-4">
                        <a href="https://instagram.com/icrp.indonesia" target="_blank"
                            class="text-gray-700 hover:text-primary-500">
                            <i class="fab fa-instagram text-2xl"></i> @icrp.indonesia
                        </a>
                        <a href="https://facebook.com/icrp.indonesia" target="_blank"
                            class="text-gray-700 hover:text-primary-500">
                            <i class="fab fa-facebook text-2xl"></i> icrp.indonesia
                        </a>
                    </div>
                </div>

                <!-- Google Maps -->
                <div>
                    <iframe width="100%" height="300" style="border:0" loading="lazy" allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.633068725179!2d106.8659217!3d-6.179844!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4ff60232a8b%3A0xc77634900d08328d!2sIndonesian%20Conference%20on%20Religion%20and%20Peace%20(ICRP)!5e0!3m2!1sid!2sid!4v1740990622369!5m2!1sid!2sid">
                    </iframe>
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
s
