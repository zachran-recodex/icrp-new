<section class="relative py-32">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ Storage::url('cta/' . $image) }}" alt="{{ $title }}" class="w-full h-full object-cover">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-primary-950/70"></div>
    </div>

    <!-- Content -->
    <div class="relative container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">
                {{ $title }}
            </h2>
            <p class="text-lg text-white/90 mb-8">
                {{ $subtitle }}
            </p>
            <a href="{{ $buttonLink }}"
               class="inline-block px-8 py-4 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition transform hover:scale-105">
                {{ $buttonText }}
            </a>
        </div>
    </div>
</section>
