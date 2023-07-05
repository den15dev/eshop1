<div class="adm_img_block">
    <div class="adm_img_b_num">{{ $loop->index + 1 }}</div>
    <div class="adm_img_b_img">
        <a href="{{ asset('storage/images/products/' . $itemid . '/' . $filename . '_1400.jpg') }}" data-fancybox="product_{{ $itemid }}">
            <img src="{{ asset('storage/images/products/' . $itemid . '/' . $filename . '_80.jpg') }}" title="{{ $filename }}" data-id="{{ $filename }}">
        </a>
    </div>
    <div class="adm_img_b_btns">
        <div class="adm_img_ctrl-btn{!! $loop->first ? '_disabled' : '' !!}"{!! $loop->first ? '' : ' title="Поднять выше" onclick="moveImage(this, \'up\')"' !!}><span class="bi-chevron-up"></span></div>
        <div class="adm_img_ctrl-btn{!! $loop->last ? '_disabled' : '' !!}"{!! $loop->last ? '' : ' title="Опустить ниже" onclick="moveImage(this, \'down\')"' !!}><span class="bi-chevron-down"></span></div>
        <div class="adm_img_ctrl-btn{!! $loop->first ? '_disabled' : '' !!}"{!! $loop->first ? '' : ' title="Поднять наверх" onclick="moveImage(this, \'top\')"' !!}><span class="bi-chevron-double-up"></span></div>
        <div class="adm_img_ctrl-btn{!! $loop->last ? '_disabled' : '' !!}"{!! $loop->last ? '' : ' title="Опустить вниз" onclick="moveImage(this, \'bottom\')"' !!}><span class="bi-chevron-double-down"></span></div>
        <div class="adm_img_ctrl-btn" title="Удалить изображение" onclick="deleteImage(this)"><span class="bi-x-lg"></span></div>
    </div>
</div>
