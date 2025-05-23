@section('meta_tag')
    <meta name="description" content="{{ optional($pageSetups['tentang'])->meta_description ?? '' }}">
    <meta name="keywords" content="{{ optional($pageSetups['tentang'])->meta_keywords ?? '' }}">
    <meta name="author" content="RECODEX ID">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="{{ optional($pageSetups['tentang'])->title ?? 'Tentang Kami' }}">
    <meta property="og:description" content="{{ optional($pageSetups['tentang'])->meta_description ?? '' }}">
    <meta property="og:image" content="{{ isset($heroSection) && $heroSection->image ? Storage::url('hero/' . $heroSection->image) : asset('images/hero.jpeg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ optional($pageSetups['tentang'])->title ?? 'Tentang Kami' }}">
    <meta name="twitter:description" content="{{ optional($pageSetups['tentang'])->meta_description ?? '' }}">
    <meta name="twitter:image" content="{{ isset($heroSection) && $heroSection->image ? Storage::url('hero/' . $heroSection->image) : asset('images/hero.jpeg') }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <title>{{ optional($pageSetups['tentang'])->title ?? 'Tentang Kami' }}</title>
@endsection

<x-main-layout>
    <!-- Hero Section -->
    <x-hero-section :title="$heroSection->title" :image="$heroSection->image" />

    <!-- About Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 space-y-12">

            <!-- Section Header -->
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-4xl font-extrabold text-primary-600 mb-4">Tentang Kami</h2>
                <p class="text-lg text-gray-600">Indonesian Conference on Religion and Peace (ICRP)</p>
            </div>

            <!-- Sejarah & Gambar -->
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="w-full md:w-1/2 text-gray-700 text-lg space-y-6 leading-relaxed">
                    <p>
                        ICRP adalah sebuah organisasi berbadan hukum yayasan yang bersifat non-sektarian, nonprofit,
                        non-pemerintah, dan independen. ICRP mempromosikan dialog dan kerjasama lintas iman dibidani
                        kelahirannya oleh para tokoh dari berbagai agama dan kepercayaan di Indonesia. ICRP berusaha
                        mempromosikan dialog dalam pengembangan kehidupan beragama yang demokratis, humanis dan
                        pluralis.
                    </p>
                    <p>
                        Jauh sebelum ICRP diresmikan pada 12 Juli 2000 oleh Presiden RI Abdurrahman Wahid, upaya-upaya
                        dialog lintas agama sudah tumbuh dan berkembang di Indonesia. ICRP bersama berbagai lembaga dan
                        individu yang peduli memperjuangkan pluralisme dan perdamaian lebih mempertegas upaya-upaya
                        tersebut demi menegakkan keadilan dalam berbagai perspektif gender, HAM, kehidupan beragama,
                        ekonomi, sosial, pendidikan, kesehatan dan politik. ICRP turut aktif dalam mengembangkan studi
                        perdamaian dan resolusi konflik, serta memperjuangkan hak-hak sipil, kebebasan beragama dan
                        berkeyakinan.
                    </p>
                </div>
                <div class="w-full md:w-1/2">
                    <img src="{{ asset('images/hero.jpeg') }}" alt="KH. Abdurrahman Wahid"
                         class="w-full h-auto rounded-xl shadow-lg">
                    <p class="text-center text-sm text-gray-500 mt-2">Source: https://www.icrp.com</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-12">
                <!-- Visi -->
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-primary-600 mb-6">Visi</h2>
                    <p class="text-lg text-gray-700 max-w-3xl mx-auto leading-relaxed">
                        Masyarakat yang damai dan sejahtera dalam konteks kemajemukan agama dan kepercayaan di Indonesia.
                    </p>
                </div>

                <!-- Misi -->
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-primary-600 mb-6">Misi</h2>
                    <ul class="text-lg text-gray-700 max-w-3xl mx-auto space-y-4 text-left list-disc list-inside">
                        <li>Menumbuhkembangkan multikulturalisme dan pluralisme dalam kehidupan Masyarakat.</li>
                        <li>
                            Membangun kesadaran dan mengembangkan budaya religiusitas yang sehat, saling menghormati dan
                            bebas dari rasa saling curiga di antara seluruh elemen bangsa khususnya komunitas dan lembaga
                            antar iman.
                        </li>
                        <li>
                            Mendorong usaha-usaha dialog, advokasi, pengkajian dan pemecahan masalah-masalah sosial politik
                            dan keagamaan baik dalam skala daerah, nasional, regional, maupun internasional.
                        </li>
                        <li>
                            Mendorong semua pihak untuk menghormati dan mensyukuri keanekaragaman dan kekayaan tradisi
                            keagamaan masing-masing.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Prinsip-Prinsip -->
            <div class="space-y-10">
                <p class="text-lg text-gray-700 font-semibold text-center mx-auto leading-relaxed">
                    Prinsip-prinsip Bumi ini disediakan oleh Sang Maha Pencipta untuk semua manusia, sehingga semua
                    manusia memiliki hak yang sama pula. Karena itu:
                </p>
                <ul class="text-lg text-gray-700 mx-auto space-y-4 list-decimal list-inside">
                    <li>
                        ICRP percaya bahwa keragaman suku, agama, budaya, adat Indonesia adalah kekayaan yang diberikan
                        Tuhan untuk mendorong integrasi sosial, bukan untuk alasan memecah belah.
                    </li>
                    <li>
                        ICRP percaya bahwa pluralisme, penghargaan terhadap yang lain, adalah pilihan sikap terbaik
                        dalam kehidupan beragama di tengah keragaman tersebut.
                    </li>
                    <li>
                        ICRP percaya bahwa misi utama agama-agama adalah terwujudnya kehidupan rukun, damai, dan
                        sejahtera, bagi manusia dan kemanusiaan secara keseluruhan.
                    </li>
                    <li>
                        ICRP percaya bahwa pada prinsipnya agama tidak mengajarkan kekerasan. Karena itu setiap
                        komunitas agama harus mengambil peran aktif untuk menolak segala bentuk kekerasan atas nama
                        agama.
                    </li>
                    <li>
                        ICRP percaya bahwa setiap individu, setiap warga negara, harus dijamin hak-hak dan kebebasan
                        sipilnya oleh negara. Termasuk di dalamnya adalah hak dan kebebasan beragama dan berkeyakinan.
                    </li>
                    <li>
                        ICRP percaya bahwa negara harus “netral agama”. Negara harus berdiri di atas semua agama dan
                        keyakinan dalam merumuskan dan mengimplementasikan setiap kebijakannya.
                    </li>
                    <li>
                        ICRP menolak “logika pengakuan” yang membawa pada kesimpulan “agama resmi” atau “agama yang
                        diakui”. Negara sudah secara otomatis harus mengakui, melindungi, dan menghargai setiap
                        pengakuan agama oleh individu maupun kelompok.
                    </li>
                    <li>
                        ICRP percaya bahwa komunitas dan kelompok agama menempati posisi strategis dan peran yang
                        signifikan dalam kehidupan berbangsa.
                    </li>
                    <li>
                        ICRP percaya bahwa kelompok agama adalah modal sosial yang harus didorong untuk berperan aktif
                        dalam pemajuan kehidupan sosial masyarakat, dan karena itu mereka harus peduli terhadap masalah
                        sosial di luar isu-isu agama.
                    </li>
                    <li>
                        ICRP menolak politisasi agama, penggunaan agama dan simbol-simbol agama untuk kepentingan
                        politik sesaat dan untuk meraih dukungan dalam politik praktis
                    </li>
                </ul>
            </div>

        </div>
    </section>

    <!-- Programs Section -->
    <section class="py-20 bg-primary-50">
        <div class="container mx-auto px-4 space-y-12">

            <!-- Section Header -->
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-4xl font-extrabold text-primary-600 mb-4">Program Kerja</h2>
                <p class="text-lg text-gray-600">Indonesian Conference on Religion and Peace (ICRP)</p>
            </div>

            @if($programs->count() > 0)
                <!-- Programs Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($programs as $program)
                        <div
                            x-data="{ openModal: false }"
                            class="relative bg-white shadow-lg rounded-lg overflow-hidden group cursor-pointer"
                        >
                            <!-- Program Card -->
                            <img
                                src="{{ Storage::url('programs/' . $program->image) }}"
                                alt="{{ $program->title }}"
                                class="w-full h-[312px] object-cover"
                                @click="openModal = true"
                            >
                            <div
                                class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-end p-6"
                                @click="openModal = true"
                            >
                                <h3 class="text-white text-xl font-semibold">{{ $program->title }}</h3>
                                <p class="text-white mt-2">
                                    {{ Str::limit(strip_tags($program->description), 80) }}
                                </p>
                            </div>

                            <!-- Modal for this program -->
                            <div
                                x-cloak
                                x-show="openModal"
                                x-transition.opacity.duration.200ms
                                x-trap.inert.noscroll="openModal"
                                @keydown.escape.window="openModal = false"
                                @click.self="openModal = false"
                                class="pl-16 fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
                                role="dialog"
                                aria-modal="true"
                                :aria-labelledby="'programModalTitle-{{ $program->id }}'"
                            >
                                <!-- Modal Dialog -->
                                <div
                                    x-show="openModal"
                                    x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
                                    x-transition:enter-start="opacity-0 scale-50"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    class="flex max-w-3xl flex-col gap-4 overflow-hidden rounded-sm border border-neutral-300 bg-white text-neutral-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300"
                                >
                                    <!-- Dialog Header -->
                                    <div class="flex items-center justify-between border-b border-neutral-300 bg-neutral-50/60 p-4 dark:border-neutral-700 dark:bg-neutral-950/20">
                                        <h3 id="programModalTitle-{{ $program->id }}" class="font-semibold tracking-wide text-neutral-900 dark:text-white">{{ $program->title }}</h3>
                                        <button @click="openModal = false" aria-label="close modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Dialog Body -->
                                    <div class="p-6 max-h-[70vh] overflow-y-auto">
                                        <div class="flex flex-col">
                                            <!-- Program Image -->
                                            <div>
                                                <img
                                                    src="{{ Storage::url('programs/' . $program->image) }}"
                                                    alt="{{ $program->title }}"
                                                    class="w-full h-auto object-cover rounded-lg"
                                                >
                                            </div>

                                            <!-- Program Details -->
                                            <div class="mt-4 space-y-4">
                                                <div>
                                                    <div class="mt-2 prose prose-sm max-w-none">
                                                        {!! $program->description !!}
                                                    </div>
                                                </div>

                                                @if($program->objectives)
                                                <div>
                                                    <h4 class="text-lg font-semibold text-primary-600">Tujuan</h4>
                                                    <div class="mt-2 prose prose-sm max-w-none">
                                                        {!! $program->objectives !!}
                                                    </div>
                                                </div>
                                                @endif

                                                @if($program->date)
                                                <div>
                                                    <h4 class="text-lg font-semibold text-primary-600">Tanggal Pelaksanaan</h4>
                                                    <p class="mt-1">{{ $program->date }}</p>
                                                </div>
                                                @endif

                                                @if($program->location)
                                                <div>
                                                    <h4 class="text-lg font-semibold text-primary-600">Lokasi</h4>
                                                    <p class="mt-1">{{ $program->location }}</p>
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
                                            class="whitespace-nowrap rounded-sm bg-primary-600 px-4 py-2 text-center text-sm font-medium tracking-wide text-white transition hover:bg-primary-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 active:opacity-100 active:outline-offset-0"
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

    <!-- CTA Section -->
    <x-call-to-action
        :title="$callToAction->title"
        :subtitle="$callToAction->subtitle"
        :image="$callToAction->image"
        :button-text="$callToAction->button_text"
        :button-link="route('kontak')"
    />
</x-main-layout>
