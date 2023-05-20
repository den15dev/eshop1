<nav class="container mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="black_link">Главная</a></li>
        @foreach($bread_crumb as $item)
            @if($loop->last)
                <li class="breadcrumb-item active" aria-current="page">{{ $item[0] }}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ route('category', $item[1]) }}" class="black_link">{{ $item[0] }}</a></li>
            @endif
        @endforeach
    </ol>
</nav>
