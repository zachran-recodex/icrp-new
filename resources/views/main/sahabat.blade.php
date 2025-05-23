@section('meta_tag')
    <meta name="description" content="{{ optional($pageSetups['sahabat'])->meta_description ?? '' }}">
    <meta name="keywords" content="{{ optional($pageSetups['sahabat'])->meta_keywords ?? '' }}">
    <meta name="author" content="RECODEX ID">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="{{ optional($pageSetups['sahabat'])->title ?? 'Sahabat ICRP' }}">
    <meta property="og:description" content="{{ optional($pageSetups['sahabat'])->meta_description ?? '' }}">
    <meta property="og:image" content="{{ isset($heroSection) && $heroSection->image ? Storage::url('hero/' . $heroSection->image) : asset('images/hero.jpeg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ optional($pageSetups['sahabat'])->title ?? 'Sahabat ICRP' }}">
    <meta name="twitter:description" content="{{ optional($pageSetups['sahabat'])->meta_description ?? '' }}">
    <meta name="twitter:image" content="{{ isset($heroSection) && $heroSection->image ? Storage::url('hero/' . $heroSection->image) : asset('images/hero.jpeg') }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <title>{{ optional($pageSetups['sahabat'])->title ?? 'Sahabat ICRP' }}</title>
@endsection

<x-main-layout>
    <!-- Hero Section -->
    <x-hero-section :title="$heroSection->title" :image="$heroSection->image" />

    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">

            <!-- Featured Article -->
            <div class="flex justify-center mt-16">
                <div class="relative rounded-2xl w-[706px] h-[405px]">
                    <img src="{{ asset('images/sahabat.png') }}" alt="Featured News"
                        class="w-[706px] h-[405px] object-cover">
                    <div class="absolute -top-20 -right-20">
                        <img src="{{ asset('images/boox.png') }}" alt="Featured News"
                             class="w-[365px] h-[197px] object-cover">
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
