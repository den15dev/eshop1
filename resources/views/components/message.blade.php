<div id="message_cont">
    <div class="message_bg"></div>
    <div class="message_win">
        <div class="message_close" title="Закрыть" onclick="document.getElementById('message_cont').remove()"><span class="bi-x-lg"></span></div>
        @if($type === 'info')
        <div class="message_icon message_icon_info"><span class="bi-info-circle"></span></div>
        @elseif($type === 'warning')
        <div class="message_icon message_icon_warning"><span class="bi-exclamation-triangle"></span></div>
        @endif
        <p class="py-2{{ $align === 'center' ? ' text-center' : '' }}">
            {{ $content }}
        </p>
        <div class="message_btns_cont">
            <div class="btn2 btn2-primary message_main_btn" onclick="document.getElementById('message_cont').remove();">OK</div>
        </div>
    </div>
</div>
