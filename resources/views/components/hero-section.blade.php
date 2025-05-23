<section class="relative min-h-[40vh] md:min-h-[50vh] flex items-center justify-center">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ Storage::url('hero/' . $image) }}" alt="{{ $title }}"
             class="w-full h-full object-cover">
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
</section>
