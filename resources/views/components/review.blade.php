<div class="item_review_block border-bottom mb-4">
    <span class="item_review_name text-color-main2 mb-1">{{ $review->user->name }}</span>
    <ul class="d-flex flex-row rating-list mb-1">
        @for($i=0; $i<5; $i++)
            @if($i < $review->mark)
            <li class="bi-star-fill"></li>
            @else
            <li class="bi-star"></li>
            @endif
        @endfor
    </ul>
    <span class="item_review_date" title="{{ \Carbon\Carbon::parse($review->created_at)->isoFormat('D MMMM YYYY, H:mm') }}">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</span>
    <span class="item_review_usetime mb-4"><span class="lightgrey_text">Срок использования:</span> {{ $review->term }}</span>

    <h6 class="fw-bold">Достоинства</h6>
    <p class="mb-4">
        @if($review->pros)
        {{ $review->pros }}
        @else
        <span class="lightgrey_text fst-italic">Не указано</span>
        @endif
    </p>

    <h6 class="fw-bold">Недостатки</h6>
    <p class="mb-4">
        @if($review->cons)
        {{ $review->cons }}
        @else
        <span class="lightgrey_text fst-italic">Не указано</span>
        @endif
    </p>

    <h6 class="fw-bold">Комментарий</h6>
    <p class="mb-4">
        @if($review->comnt)
        {{ $review->comnt }}
        @else
        <span class="lightgrey_text fst-italic">Не указано</span>
        @endif
    </p>

    <livewire:reactions :review="$review" :userid="$userid" />
</div>
