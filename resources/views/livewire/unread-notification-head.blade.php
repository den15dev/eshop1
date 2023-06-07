<div class="d-flex justify-content-between note_block">
    <span class="d-block grey_text mb-3">{{ $report }}</span>
    @if($num)
        <span class="d-block blue_link" role="button" wire:click="markAllAsRead">Отметить все прочитанными</span>
    @endif
</div>
