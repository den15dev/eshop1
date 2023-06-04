<div class="d-flex flex-row cat_top_cont mb-2" id="cat_top_menu">
    <label for="sort_results" class="mt-1 me-2">Сортировать:</label>
    <select class="form-select form-select-sm cat_sort_select" id="sort_results" onchange="changeLayout(0, this.value)">
        <option value="1"{{ $layout[0] == 1 ? ' selected' : '' }}>сначала дешёвые</option>
        <option value="2"{{ $layout[0] == 2 ? ' selected' : '' }}>сначала дорогие</option>
        <option value="3"{{ $layout[0] == 3 ? ' selected' : '' }}>сначала новинки</option>
        <option value="4"{{ $layout[0] == 4 ? ' selected' : '' }}>сначала популярные</option>
        <option value="5"{{ $layout[0] == 5 ? ' selected' : '' }}>сначала со скидкой</option>
    </select>

    <div class="d-flex flex-row ms-auto me-1">
        <label for="per_page" class="num_on_page_label mt-1 me-2">На странице:</label>
        <select class="form-select form-select-sm cat_sort_select me-3" id="per_page" onchange="changeLayout(1, this.value)">
            <option value="12"{{ $layout[1] == 12 ? ' selected' : '' }}>12</option>
            <option value="24"{{ $layout[1] == 24 ? ' selected' : '' }}>24</option>
            <option value="36"{{ $layout[1] == 36 ? ' selected' : '' }}>36</option>
            <option value="48"{{ $layout[1] == 48 ? ' selected' : '' }}>48</option>
        </select>

        <div style="line-height: 31px">
            @if($layout[2] == 1)
            <span class="text-color-main2 fs-4"><i class="bi bi-grid"></i></span>
            <span class="text-secondary fs-4 ms-1" role="button" onclick="changeLayout(2, 2)"><i class="bi bi-list"></i></span>
            @else
            <span class="text-secondary fs-4" role="button" onclick="changeLayout(2, 1)"><i class="bi bi-grid"></i></span>
            <span class="text-color-main2 fs-4 ms-1"><i class="bi bi-list"></i></span>
            @endif
        </div>
    </div>
</div>

<script>
    function changeLayout(section, value) {
        let layout = JSON.parse(decodeURIComponent(getCookieValue('layout')));
        layout[section] = parseInt(value, 10);
        document.cookie = 'layout=' + encodeURIComponent(JSON.stringify(layout)) + '; path=/;  max-age=157680000';
        window.location.reload();
    }
</script>
