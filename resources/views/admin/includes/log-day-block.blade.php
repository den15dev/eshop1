<h4 class="mb-3">{{ \Carbon\Carbon::parse($day_log[0])->isoFormat('DD MMMM') }}</h4>
<table class="small" data-date="{{ $day_log[0] }}">
    @foreach($day_log[1] as $event)
        <tr>
            <td class="pb-2 lightgrey_text me-3 align-text-top">{!! $event[0] !!}</td>
            <td class="pb-2 ps-2 text-break align-text-top">{!! $event[1] !!}</td>
        </tr>
    @endforeach
</table>
