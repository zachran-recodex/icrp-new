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

    <title>Jaringan</title>
@endsection

<x-layouts.main>
    <!-- Hero Section -->
    <x-hero-section :title="$heroSection->title" :image="$heroSection->image" />

    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 space-y-12">

            <!-- Section Header -->
            <div class="max-w-3xl mx-auto text-center mb-8">
                <h2 class="text-3xl md:text-4xl text-primary-500 font-bold mb-4">Jaringan & Kemitraan</h2>
                <p class="text-gray-600">
                    ICRP memiliki jaringan dan kemitraan yang luas dengan berbagai organisasi, lembaga swadaya masyarakat, komunitas lintas iman, akademisi, dan media. Kemitraan ini bertujuan untuk mempromosikan perdamaian, toleransi, dan dialog antaragama di Indonesia.
                </p>
            </div>

            <div class="max-w-3xl mx-auto text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Mitra Lembaga - Lembaga Agama</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="flex flex-col items-center text-center p-4">
                    <div class="w-32 h-32 mb-4">
                        <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fa-solid fa-user text-gray-400 text-4xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Komunitas Agama</h3>
                    <p class="text-sm text-gray-600 max-w-sm">As one of the founders of ICRP, Prof. Maria Sukmawati has been an inspiration in building bridges for inter-religious dialogue in Indonesia.</p>
                </div>

                <div class="flex flex-col items-center text-center p-4">
                    <div class="w-32 h-32 mb-4">
                        <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fa-solid fa-user text-gray-400 text-4xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Lembaga Agama</h3>
                    <p class="text-sm text-gray-600 max-w-sm">As one of the founders of ICRP, Prof. Maria Sukmawati has been an inspiration in building bridges for inter-religious dialogue in Indonesia.</p>
                </div>
            </div>

            <div class="max-w-3xl mx-auto text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Mitra Dialog Antar Agama</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="flex flex-col items-center text-center p-4">
                    <div class="w-32 h-32 mb-4">
                        <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fa-solid fa-user text-gray-400 text-4xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Mitra Pengusaha</h3>
                </div>

                <div class="flex flex-col items-center text-center p-4">
                    <div class="w-32 h-32 mb-4">
                        <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fa-solid fa-user text-gray-400 text-4xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Mitra Media</h3>
                </div>

                <div class="flex flex-col items-center text-center p-4">
                    <div class="w-32 h-32 mb-4">
                        <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fa-solid fa-user text-gray-400 text-4xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Mitra Agama</h3>
                </div>

                <div class="flex flex-col items-center text-center p-4">
                    <div class="w-32 h-32 mb-4">
                        <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fa-solid fa-user text-gray-400 text-4xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Mitra Aktivis</h3>
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
