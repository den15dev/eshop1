<div class="note_block">
    <div class="note_head" data-id="{{ $notification->id }}" data-unread="{{ $notification->is_unread }}" onclick="unfoldNote(this)">
        <div class="note_head_arrow grey_text">
            <span class="bi-caret-right{{ $notification->is_unread ? '-fill text-color-red' : '' }}"></span>
        </div>
        <div class="note_head_title">
            <span class="{{ $notification->is_unread ? 'fw-bold' : 'fw-normal' }}">{{ $notification->title }}</span>
        </div>
        <div class="note_head_date grey_text small">
            {{ \Carbon\Carbon::parse($notification->created_at)->isoFormat('D MMMM YYYY, H:mm') }}
        </div>
    </div>

    <div class="note_body">
        {{ $notification->message }}
    </div>
</div>
