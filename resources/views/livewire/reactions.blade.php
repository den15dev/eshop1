<div class="mb-4">
    <span class="{{ $wrap_class_up }}" @if($userid && !$is_author) wire:click="like" @endif>
        <span class="{{ $icon_class_up }} fs-5 me-1"></span>
        {{ $up_counted }}
    </span>
    <span class="{{ $wrap_class_down }} ms-2" @if($userid && !$is_author) wire:click="dislike" @endif>
        <span class="{{ $icon_class_down }} fs-5 me-1" style="vertical-align: -4px"></span>
        {{ $down_counted }}
    </span>
</div>
