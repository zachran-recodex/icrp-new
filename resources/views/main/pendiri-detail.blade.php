@section('meta_tag')
    <meta name="description" content="{!! $founder->biography !!}">
    <meta name="keywords" content="{{ optional($pageSetups['pendiri'])->meta_keywords ?? '' }}">
    <meta name="author" content="RECODEX ID">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="{{ $founder->title }} | {{ optional($pageSetups['pendiri'])->title ?? 'Profil Pendiri ICRP' }}">
    <meta property="og:description" content="{!! $founder->biography !!}">
    <meta property="og:image" content="{{ Storage::url('founders/' . $founder->image) }}"">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $founder->title }} | {{ optional($pageSetups['pendiri'])->title ?? 'Profil Pendiri ICRP' }}">
    <meta name="twitter:description" content="{!! $founder->biography !!}">
    <meta name="twitter:image" content="{{ Storage::url('founders/' . $founder->image) }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <title>{{ $founder->name }} | {{ optional($pageSetups['pendiri'])->title ?? 'Profil Pendiri ICRP' }}</title>
@endsection

<x-main-layout>
    <!-- Hero Section -->
    <x-hero-section :title="$heroSection->title" :image="$heroSection->image" />

    <!-- Founder Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <!-- Tombol Back -->
            <div class="mb-8">
                <a href="{{ route('pendiri') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-full text-gray-800 transition duration-300 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Jajaran Pendiri
                </a>
            </div>

            <!-- Founder Header -->
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-2">{{ $founder->name }}</h2>
                <div class="w-24 h-1 bg-primary-600 mx-auto mb-4"></div>
                <p class="text-xl text-gray-600">{{ $founder->known_as }}</p>
            </div>

            <!-- Founder Content -->
            <div class="flex flex-col lg:flex-row gap-10">
                <!-- Left Side: Image and Quick Facts -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                        <div class="relative">
                            @if($founder->image)
                                <img src="{{ Storage::url('founders/' . $founder->image) }}" alt="{{ $founder->name }}" class="w-full h-auto">
                            @else
                                <div class="bg-gray-200 w-full h-64 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                            @if($founder->nickname)
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                    <h3 class="text-white text-2xl font-bold">{{ $founder->nickname }}</h3>
                                </div>
                            @endif
                        </div>

                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="font-semibold text-gray-700">Lahir:</div>
                                <div>{{ $founder->birth_date ? $founder->birth_date->format('d F Y') : '-' }}</div>

                                @if($founder->death_date)
                                    <div class="font-semibold text-gray-700">Wafat:</div>
                                    <div>{{ $founder->death_date->format('d F Y') }}</div>
                                @endif

                                <div class="font-semibold text-gray-700">Tempat Lahir:</div>
                                <div>{{ $founder->birth_place }}</div>

                                <div class="font-semibold text-gray-700">Dikenal sebagai:</div>
                                <div>{{ $founder->known_as }}</div>
                            </div>

                            @if($founder->quote)
                                <div class="border-t border-gray-200 pt-4">
                                    <blockquote class="italic text-gray-700 border-l-4 border-primary-600 pl-4 py-2">
                                        "{{ $founder->quote }}"
                                    </blockquote>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Side: Biography and Contributions -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-primary-600 rounded-full flex items-center justify-center text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="ml-4 text-2xl font-bold text-gray-800">Biografi</h3>
                        </div>

                        <div class="prose max-w-none text-gray-700">
                            {!! $founder->biography !!}
                        </div>

                        @if($founder->contributions->count() > 0)
                            <div class="mt-8">
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-primary-600 rounded-full flex items-center justify-center text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="ml-4 text-2xl font-bold text-gray-800">Kontribusi</h3>
                                </div>

                                <div class="grid md:grid-cols-2 gap-4">
                                    @foreach($founder->contributions as $contribution)
                                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-primary-600">
                                            <h4 class="font-semibold text-gray-800">{{ $contribution->title }}</h4>
                                            <p class="text-gray-700 text-sm">{{ $contribution->description }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($founder->legacies->count() > 0)
                            <div class="mt-8">
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-primary-600 rounded-full flex items-center justify-center text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <h3 class="ml-4 text-2xl font-bold text-gray-800">Warisan Pemikiran</h3>
                                </div>

                                <div class="prose max-w-none text-gray-700">
                                    {!! $founder->legacies->first()->content !!}
                                </div>
                            </div>
                        @endif
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
