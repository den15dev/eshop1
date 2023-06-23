@if($paginator->total())
    <p class="small text-muted">
        {!! __('Showing') !!}
        {{ $paginator->firstItem() }}
        {!! __('to') !!}
        {{ $paginator->lastItem() }}
        {!! __('of') !!}
        {{ $paginator->total() }}
        {!! __('results') !!}
    </p>
@endif
