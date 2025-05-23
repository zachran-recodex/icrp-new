@section('meta_tag')
    <meta name="description" content="{{ optional($pageSetups['pendiri'])->meta_description ?? '' }}">
    <meta name="keywords" content="{{ optional($pageSetups['pendiri'])->meta_keywords ?? '' }}">
    <meta name="author" content="RECODEX ID">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="{{ optional($pageSetups['pendiri'])->title ?? 'Profil Pendiri ICRP' }}">
    <meta property="og:description" content="{{ optional($pageSetups['pendiri'])->meta_description ?? '' }}">
    <meta property="og:image" content="{{ isset($heroSection) && $heroSection->image ? Storage::url('hero/' . $heroSection->image) : asset('images/hero.jpeg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ optional($pageSetups['pendiri'])->title ?? 'Profil Pendiri ICRP' }}">
    <meta name="twitter:description" content="{{ optional($pageSetups['pendiri'])->meta_description ?? '' }}">
    <meta name="twitter:image" content="{{ isset($heroSection) && $heroSection->image ? Storage::url('hero/' . $heroSection->image) : asset('images/hero.jpeg') }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <title>{{ optional($pageSetups['pendiri'])->title ?? 'Profil Pendiri ICRP' }}</title>
@endsection

<x-main-layout>
    <!-- Hero Section -->
    <x-hero-section :title="$heroSection->title" :image="$heroSection->image" />

    <!-- Founder Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 space-y-12">

            <!-- Section Header -->
            <div class="max-w-3xl mx-auto text-center mb-8">
                <h2 class="text-3xl md:text-4xl text-primary-500 font-bold mb-4">Jajaran Pendiri ICRP</h2>
            </div>

            @if($founders->count() > 0)
                <!-- Grid Founders -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($founders as $founder)
                        <a href="{{ route('pendiri.detail', $founder->slug) }}" class="flex flex-col items-center text-center p-4">
                            <div class="w-32 h-32 mb-4">
                                <img src="{{ Storage::url('founders/' . $founder->image) }}" alt="{{ $founder->name }}"
                                     class="w-full h-full rounded-full object-cover border">
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $founder->name }}</h3>
                        </a>
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
