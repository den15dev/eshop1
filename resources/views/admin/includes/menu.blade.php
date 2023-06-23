<div class="col adm_sidebar_cont">
    <ul class="adm_sidebar_list">
        @foreach($nav_items as $item)
            <x-admin.nav-item :name="$item[0]" :routename="$item[1]" :icon="$item[2]" />
        @endforeach
    </ul>
</div>
