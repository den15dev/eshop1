<td>
    @if($title !== '')
        <div {!! $sortable ? 'class="lightgrey_link"' : '' !!} data-id="{{ $column }}" data-orderby="" {!! $sortable ? 'onclick="changeOrder(\'' . $column . '\')"' : '' !!}>
        {{ $title }}
        @if($orderby === 'asc')
            <span class="bi-caret-down-fill small"></span>
        @elseif($orderby === 'desc')
            <span class="bi-caret-up-fill small"></span>
        @else
            <span style="display: none"></span>
        @endif
        </div>
    @endif
</td>
