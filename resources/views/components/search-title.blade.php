<div class="search_result_main_title">
    @if($url) <a href="{{ $url }}" class="black_link"> @endif
        <span class="fw-semibold">{{ $title }}</span>
        <span class="grey_text">({{ $num }})</span>
    @if($url) </a> @endif
</div>
