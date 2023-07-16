@extends('admin.layout')

@section('page_title', 'Отзыв #' . $review->id . ' - Редактирование')

@section('main_content')

    <h3 class="mb-3">Отзыв #{{ $review->id }}</h3>

    <div class="mb-3">
        <div>
            <span class="lightgrey_text">Товар:</span>&nbsp;
            <a href="{{ route('product', [$review->product->category_slug, $review->product->slug . '-' . $review->product->id]) }}" class="blue_link">{{ $review->product->name }}</a>
        </div>
        <div>
            <span class="lightgrey_text">Автор:</span>&nbsp;
            <a href="{{ route('admin.users.edit', $review->user->id) }}" class="blue_link">{{ $review->user->name }}</a>
        </div>
        <div>
            <span class="lightgrey_text">Дата публикации:</span>&nbsp;{{ \Carbon\Carbon::parse($review->created_at)->isoFormat('DD MMMM YYYY, H:mm') }}
        </div>
        <div>
            <span class="lightgrey_text">Срок использования:</span>&nbsp;{{ $review->term }}
        </div>
        <div>
            <span class="lightgrey_text">Оценка товару:</span>&nbsp;{{ $review->mark }}
        </div>
        <div>
            <span class="lightgrey_text">Лайков:</span>&nbsp;{{ $review->up_votes }}
        </div>
        <div>
            <span class="lightgrey_text">Дизлайков:</span>&nbsp;{{ $review->down_votes }}
        </div>
    </div>


    <div class="adm_form_cont">
        <form method="POST" action="{{ route('admin.reviews.update', $review->id) }}" class="mb-4" id="edit_form" novalidate>
            @method('PUT')
            @csrf
            <x-admin.textarea name="pros" label="Достоинства" :value="$review->pros" />
            <x-admin.textarea name="cons" label="Недостатки" :value="$review->cons" />
            <x-admin.textarea name="comnt" label="Комментарий" :value="$review->comnt" />
        </form>

        <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" id="delete_form" onsubmit="return confirmDeleting(this, 'удалить отзыв {{ $review->id }}?')" novalidate>
            @method('DELETE')
            @csrf
            <input type="hidden" name="product_id" value="{{ $review->product_id }}" />
        </form>

        <div class="d-flex flex-row mb-2">
            <button type="submit" form="edit_form" class="btn2 btn2-primary submit_btn2 me-2">Сохранить</button>
            <button type="submit" form="delete_form" class="btn2 btn2-red submit_btn2">Удалить</button>
        </div>
        <div class="small grey_text fst-italic mb-2"><span class="fw-semibold text-color-main">Внимание!</span> При удалении отзыва соответствующая оценка товара и все реакции на отзыв также будут удалены.</div>
    </div>

@endsection
