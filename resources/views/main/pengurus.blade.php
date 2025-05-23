@section('meta_tag')
    <meta name="description" content="{{ optional($pageSetups['pengurus'])->meta_description ?? '' }}">
    <meta name="keywords" content="{{ optional($pageSetups['pengurus'])->meta_keywords ?? '' }}">
    <meta name="author" content="RECODEX ID">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="{{ optional($pageSetups['pengurus'])->title ?? 'Pengurus ICRP' }}">
    <meta property="og:description" content="{{ optional($pageSetups['pengurus'])->meta_description ?? '' }}">
    <meta property="og:image" content="{{ isset($heroSection) && $heroSection->image ? Storage::url('hero/' . $heroSection->image) : asset('images/hero.jpeg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ optional($pageSetups['pengurus'])->title ?? 'Pengurus ICRP' }}">
    <meta name="twitter:description" content="{{ optional($pageSetups['pengurus'])->meta_description ?? '' }}">
    <meta name="twitter:image" content="{{ isset($heroSection) && $heroSection->image ? Storage::url('hero/' . $heroSection->image) : asset('images/hero.jpeg') }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <title>{{ optional($pageSetups['pengurus'])->title ?? 'Pengurus ICRP' }}</title>
@endsection

<x-main-layout>
    <!-- Hero Section -->
    <x-hero-section :title="$heroSection->title" :image="$heroSection->image" />

    <!-- Management Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 space-y-12">

            <!-- Section Header -->
            <div class="max-w-3xl mx-auto text-center mb-8">
                <h2 class="text-3xl md:text-4xl text-primary-500 font-bold mb-4">Pengurus ICRP</h2>
                <p class="text-gray-600">
                    Berikut ini adalah para pengurus yang menjalankan ICRP, menjalankan misi perdamaian,
                    kerukunan dan dialog antaragama di Indonesia.
                </p>
            </div>

            @if($dewanDirectureExcecutive->count() > 0)
                <div class="max-w-3xl mx-auto text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Directure Excecutive</h2>
                </div>

                <!-- Dewan Pengurus Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($dewanDirectureExcecutive as $member)
                        <a href="{{ route('pengurus.detail', $member->slug) }}" class="flex flex-col items-center text-center p-4">
                            <div class="w-32 h-32 mb-4">
                                @if($member->image)
                                    <img src="{{ Storage::url('managements/' . $member->image) }}" alt="{{ $member->name }}"
                                         class="w-full h-full rounded-full object-cover">
                                @else
                                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fa-solid fa-user text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $member->name }}</h3>
                            <p class="text-primary-600 mb-2">{{ $member->position }}</p>
                            <p class="text-sm text-gray-600 max-w-sm">{{ Str::limit(strip_tags($member->biography), 100) }}</p>
                        </a>
                    @endforeach
                </div>
            @endif

            @if($dewanPengurus->count() > 0)
                <div class="max-w-3xl mx-auto text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Dewan Pengurus</h2>
                </div>

                <!-- Dewan Pengurus Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($dewanPengurus as $member)
                        <a href="{{ route('pengurus.detail', $member->slug) }}" class="flex flex-col items-center text-center p-4">
                            <div class="w-32 h-32 mb-4">
                                @if($member->image)
                                    <img src="{{ Storage::url('managements/' . $member->image) }}" alt="{{ $member->name }}"
                                         class="w-full h-full rounded-full object-cover">
                                @else
                                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fa-solid fa-user text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $member->name }}</h3>
                            <p class="text-primary-600 mb-2">{{ $member->position }}</p>
                            <p class="text-sm text-gray-600 max-w-sm">{{ Str::limit(strip_tags($member->biography), 100) }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($dewanKehormatan->count() > 0)
                <div class="max-w-3xl mx-auto text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Dewan Kehormatan</h2>
                </div>

                <!-- Dewan Kehormatan Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($dewanKehormatan as $member)
                        <a href="{{ route('pengurus.detail', $member->slug) }}" class="flex flex-col items-center text-center p-4">
                            <div class="w-32 h-32 mb-4">
                                @if($member->image)
                                    <img src="{{ Storage::url('managements/' . $member->image) }}" alt="{{ $member->name }}"
                                         class="w-full h-full rounded-full object-cover">
                                @else
                                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fa-solid fa-user text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $member->name }}</h3>
                            <p class="text-primary-600 mb-2">{{ $member->position }}</p>
                            <p class="text-sm text-gray-600 max-w-sm">{{ Str::limit(strip_tags($member->biography), 100) }}</p>
                        </a>
                    @endforeach
                </div>
            @endif

            @if($dewanPembina->count() > 0)
                <div class="max-w-3xl mx-auto text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Dewan Pembina</h2>
                </div>

                <!-- Dewan Pembina Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($dewanPembina as $member)
                        <a href="{{ route('pengurus.detail', $member->slug) }}" class="flex flex-col items-center text-center p-4">
                            <div class="w-32 h-32 mb-4">
                                @if($member->image)
                                    <img src="{{ Storage::url('managements/' . $member->image) }}" alt="{{ $member->name }}"
                                         class="w-full h-full rounded-full object-cover">
                                @else
                                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fa-solid fa-user text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $member->name }}</h3>
                            <p class="text-primary-600 mb-2">{{ $member->position }}</p>
                            <p class="text-sm text-gray-600 max-w-sm">{{ Str::limit(strip_tags($member->biography), 100) }}</p>
                        </a>
                    @endforeach
                </div>
            @endif

            @if($dewanPengawas->count() > 0)
                <div class="max-w-3xl mx-auto text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Dewan Pengawas</h2>
                </div>

                <!-- Dewan Pengawas Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($dewanPengawas as $member)
                        <a href="{{ route('pengurus.detail', $member->slug) }}" class="flex flex-col items-center text-center p-4">
                            <div class="w-32 h-32 mb-4">
                                @if($member->image)
                                    <img src="{{ Storage::url('managements/' . $member->image) }}" alt="{{ $member->name }}"
                                         class="w-full h-full rounded-full object-cover">
                                @else
                                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fa-solid fa-user text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $member->name }}</h3>
                            <p class="text-primary-600 mb-2">{{ $member->position }}</p>
                            <p class="text-sm text-gray-600 max-w-sm">{{ Str::limit(strip_tags($member->biography), 100) }}</p>
                        </a>
                    @endforeach
                </div>
            @endif

            @if($dewanPengurusHarian->count() > 0)
                <div class="max-w-3xl mx-auto text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Dewan Pengurus Harian</h2>
                </div>

                <!-- Dewan Pengurus Harian Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($dewanPengurusHarian as $member)
                        <a href="{{ route('pengurus.detail', $member->slug) }}" class="flex flex-col items-center text-center p-4">
                            <div class="w-32 h-32 mb-4">
                                @if($member->image)
                                    <img src="{{ Storage::url('managements/' . $member->image) }}" alt="{{ $member->name }}"
                                         class="w-full h-full rounded-full object-cover">
                                @else
                                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fa-solid fa-user text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $member->name }}</h3>
                            <p class="text-primary-600 mb-2">{{ $member->position }}</p>
                            <p class="text-sm text-gray-600 max-w-sm">{{ Str::limit(strip_tags($member->biography), 100) }}</p>
                        </a>
                    @endforeach
                </d>
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
