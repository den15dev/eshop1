{{-- ---------- Index table ----------- --}}

<table class="table text-center small mb-4 align-middle" data-id="{{ $table_name }}" id="index_table">
    <thead>
    <tr class="lightgrey_text">
        @foreach($columns as $column)
            <x-admin.column-title
                :column="$column[0]"
                :title="$column[1]"
                :sortable="$column[2]"
                :orderby="$column[3]" />
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($table_data as $record)
        <tr>
            @foreach($record as $column => $value)
                @if($column === 'image')
                    <td><img src="{{ asset('storage/images/' . $table_name . '/' . $value) }}"></td>
                @elseif($column === 'images')
                    <td><img src="{{ asset('storage/images/' . $table_name . '/temp/' . ($record->id % 20 + 1) . '/' . json_decode($value)[0] . '_80.jpg') }}"></td>
                @elseif($column === 'name')
                    <td class="text-start">{{ $value }}</td>
                @elseif(preg_match('/price/', $column))
                    <td>{{ format_price($value) }} ₽</td>
                @elseif($column === 'is_active')
                    <td>{!! $value ? 'да' : '<span class="lightgrey_text">нет</span>' !!}</td>
                @else
                    <td>{{ $value }}</td>
                @endif
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
