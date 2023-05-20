<h3 class="mb-45">{{ $title }}</h3>

<section class="splide {{ $section }} mb-3" aria-label="{{ $title }}">
    <div class="splide__track">
        <ul class="splide__list">
            {{ $slot }}
        </ul>
    </div>
</section>
