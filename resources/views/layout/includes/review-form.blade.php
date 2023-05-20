<form class="ms-0 me-auto mb-4" method="POST" action="{{ route('review.add', [$category_slug, $product_slug]) }}#reviews" id="add_review_form" onsubmit="return validateReviewForm()">
    @csrf
    @if($user_id)
    @if($is_reviewed)
    <h3 class="mb-3 lightgrey_text fw-normal">Ваш отзыв был опубликован</h3>
    @else
    <h3 class="mb-3">Оставить отзыв</h3>
    @endif
    @else
    <h3 class="mb-3 lightgrey_text fw-normal">Зарегистрируйтесь или войдите, чтобы оставлять отзывы</h3>
    @endif

    <ul class="d-flex flex-row rating-list-big mb-2" id="{{ $user_id && !$is_reviewed ? 'item_rate_stars' : 'item_rate_stars_disabled' }}">
        <li class="bi-star"></li>
        <li class="bi-star"></li>
        <li class="bi-star"></li>
        <li class="bi-star"></li>
        <li class="bi-star"></li>
    </ul>
    <div class="text-color-red pb-2" id="rating_note" style="display: none"><span class="bi-arrow-up me-2"></span>Пожалуйста, поставьте оценку товару</div>
    <input type="hidden" name="mark" value="{{ old('rating') }}" id="rating_input"/>
    <input type="hidden" name="product_id" value="{{ $product->id }}" />

    <label for="term_of_use" class="mt-2 mb-1">Срок использования:</label>
    <select class="form-select cat_sort_select mb-3" name="term_of_use" id="term_of_use"{{ $user_id && !$is_reviewed ? '' : ' disabled' }}>
        <option value="days"{{ old('term_of_use') == 'days' ? ' selected' : '' }}>Несколько дней</option>
        <option value="weeks"{{ old('term_of_use') == 'weeks' ? ' selected' : '' }}>Несколько недель</option>
        <option value="months"{{ old('term_of_use') == 'months' ? ' selected' : '' }}>Несколько месяцев</option>
        <option value="years"{{ old('term_of_use') == 'years' ? ' selected' : '' }}>Несколько лет</option>
    </select>

    <div class="mb-3">
        <label for="item_pros_form" class="form-label">Достоинства:</label>
        <textarea class="form-control" name="pros" id="item_pros_form" placeholder="Необязательно для заполнения" style="height: 100px"{{ $user_id && !$is_reviewed ? '' : ' disabled' }}>{{ old('pros') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="item_cons_form" class="form-label">Недостатки:</label>
        <textarea class="form-control" name="cons" id="item_cons_form" placeholder="Необязательно для заполнения" style="height: 100px"{{ $user_id && !$is_reviewed ? '' : ' disabled' }}>{{ old('cons') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="item_comment_form" class="form-label">Комментарий:</label>
        <textarea class="form-control" name="comment" id="item_comment_form" placeholder="Необязательно для заполнения" style="height: 100px"{{ $user_id && !$is_reviewed ? '' : ' disabled' }}>{{ old('comment') }}</textarea>
    </div>

    @if($user_id && !$is_reviewed)
    <button type="submit" class="btn2 btn2-primary adm_main_form_btn px-4">Отправить</button>
    @else
    <div class="btn2 btn2-inactive adm_main_form_btn px-4">Отправить</div>
    @endif
</form>
