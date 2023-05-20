<nav class="mb-0" id="pagination">
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Назад</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link link-dark" href="{{ $paginator->previousPageUrl() }}" rel="prev">Назад</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="page-link">{{ $element }}</span>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link link-dark" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link link-dark" href="{{ $paginator->nextPageUrl() }}" rel="next">Вперёд</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link" aria-hidden="true">Вперёд</span>
            </li>
        @endif
    </ul>
</nav>

