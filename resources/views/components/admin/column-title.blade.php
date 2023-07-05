<td>
    @if($title !== '')
        <div {!! $sortable ? 'class="lightgrey_link text-nowrap"' : '' !!} data-id="{{ $column }}" data-orderby="" {!! $sortable ? 'onclick="changeOrder(\'' . $column . '\')"' : '' !!}>
            {{ $title }}
            @if($orderdir === 'asc')
            <span class="bi-caret-down-fill" style="font-size: 0.5rem"></span>
            @elseif($orderdir === 'desc')
            <span class="bi-caret-up-fill" style="font-size: 0.5rem"></span>
            @else
            <span style="display: none; font-size: 0.5rem"></span>
            @endif
        </div>
    @endif
</td>
