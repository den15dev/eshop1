{{-- ---------- Index table ----------- --}}

<table class="table text-center small mb-4 align-middle" data-id="{{ $table_name }}" id="index_table">
    <thead>
    <tr class="lightgrey_text">
        @foreach($columns as $column)
            <x-admin.column-title
                :column="$column['column']"
                :title="$column['title']"
                :sortable="$column['is_sortable']"
                :orderdir="$column['order_dir'] ?? false" />
        @endforeach
    </tr>
    </thead>
    <tbody>
        @foreach($table_data as $record)
            <tr>
                @foreach($columns as $column)
                    @php
                    $col_name = $column['column'];
                    $value = $record->$col_name;

                    $length_limit = 70;
                    $value = (gettype($value) === 'string' && mb_strlen($value) > $length_limit)
                        ? mb_substr($value, 0, $length_limit).'...'
                        : $value;

                    $td_content = match ($col_name) {
                        'image' => $value ? '<img src="' . asset('storage/images/' . $table_name . '/' . $record->id . '/' . $value) . '">' : '',
                        'images' => $value ? '<img src="' . get_image('storage/images/' . $table_name . '/' . $record->id . '/' . $value[0] . '_80.jpg', 80) . '">'
                                            : '<img src="' . asset('storage/images/default/no-image_80.jpg') . '">',
                        'slug' => '<img src="' . getImageByNameBase('storage/images/' . $table_name . '/' . $value) . '" style="height: 16px">',
                        'price', 'final_price', 'total_cost' => format_price($value),
                        'is_active' => $value ? 'да' : '<span class="lightgrey_text">нет</span>',
                        'role' => $value === 'admin' || $value === 'boss' ?
                            '<span class="text-color-red">' . $value . '</span>' :
                            '<span class="lightgrey_text">' . $value . '</span>',
                        'status' => match ($value) {
                            'new' => '<span class="text-color-red">' . $record->status_str . '</span>',
                            'completed' => '<span class="lightgrey_text">' . $record->status_str . '</span>',
                            'cancelled' => '<span class="lightgrey_text fst-italic">' . $record->status_str . '</span>',
                            'ready', 'sent' => '<span class="text-color-green">' . $record->status_str . '</span>',
                            default => $record->status_str,
                        },
                        'delivery_type' => match ($value) {
                            'self' => '<span class="lightgrey_text">' . $record->delivery_type_str . '</span>',
                            default => $record->delivery_type_str,
                        },
                        'payment_status' => $value ? '<span class="lightgrey_text">оплачен</span>' : 'не оплачен',
                        'until' => \Carbon\Carbon::parse($value)->isoFormat('D MMMM YYYY'),
                        default => $value,
                    };

                    $td_class = match ($column['align']) {
                        'start' => 'class="text-start"',
                        'end' => 'class="text-end"',
                        default => '',
                    };

                    if ($loop->index < 3) {
                        $td_content = '<a href="' . route('admin.' . $table_name . '.edit', $record->id) . '" class="dark_link">' . $td_content . '</a>';
                    }
                    @endphp

                    <td {!! $td_class !!}>{!! $td_content !!}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

@empty($table_data->count())
    <div class="text-center mb-3 lightgrey_text">Ничего не найдено</div>
@endempty

{{-- ---------- Pagination ----------- --}}

{{ $table_data->links('layout.pagination.results-shown') }}

<div class="d-lg-flex justify-content-between mb-5">
    {{ $table_data->onEachSide(1)->withPath(route('admin.search'))->withQueryString()->appends(['table' => $table_name])->links('layout.pagination.page-links') }}

        <div class="d-flex">
        <label for="show_per_page" class="mt-1 me-2">На странице:</label>
        <select class="form-select form-select-sm w-auto me-3" id="show_per_page" style="height: 34px" onchange="changePerPageNum(this.value)">
            <option value="5"{{ $per_page == 5 ? ' selected' : '' }}>5</option>
            <option value="10"{{ $per_page == 10 ? ' selected' : '' }}>10</option>
            <option value="15"{{ $per_page == 15 ? ' selected' : '' }}>15</option>
            <option value="25"{{ $per_page == 25 ? ' selected' : '' }}>25</option>
            <option value="40"{{ $per_page == 40 ? ' selected' : '' }}>40</option>
        </select>
    </div>
</div>
