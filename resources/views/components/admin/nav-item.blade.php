<li>
    <a href="{{ route('admin.' . $routename) }}" class="d-block black_link {{ active_link('admin.' . $routename, 'fw-bold adm_sidebar_active') }}">
        <span class="bi-{{ $icon }} me-1"></span>
        {{ $name }}
        @if($badge)
            <span class="count_badge_red">{{ $badge }}</span>
        @endif
        {!! active_link('admin.' . $routename, '<span class="bi-chevron-right adm_sidebar_chevron lightgrey_text" style="font-size:0.7rem"></span>') !!}
    </a>
</li>
