<tr>
    <td>
        <ul class="d-flex flex-row rating-list small me-2">
            @for($i=0; $i<5; $i++)
            @if($i < $mark)
            <li class="bi-star-fill"></li>
            @else
            <li class="bi-star"></li>
            @endif
            @endfor
        </ul>
    </td>
    <td>
        <div class="score_chart_col_bg me-2">
            <div class="score_chart_col bg-color-main" style="width: {{ $max ? round($num * 100 / $max) : 0 }}%"></div>
        </div>
    </td>
    <td>{!! $num > 0 ? $num : '<span class="lightgrey_text">' . $num . '</span>' !!}</td>
</tr>
