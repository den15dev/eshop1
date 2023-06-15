<ul class="dropdown-menu">
    @php
        function build_cat_menu($menu_arr) {
            foreach ($menu_arr as $item) {
                $products_num = $item[2] ? ' <span class="small lightgrey_text">' . $item[2] . '</span>' : '';
                if (count($item) < 4) {
                    echo '<li><a class="dropdown-item" href="' . route('category', [$item[1]]) . '">' . $item[0] . $products_num . '</a></li>' . "\n";
                } else {
                    echo '<li class="dropend">' . "\n";
                    echo '<a class="dropdown-item" href="' . route('category', [$item[1]]) . '">' . $item[0] . $products_num . '</a>' . "\n";
                    echo '<ul class="dropdown-menu dropdown-submenu">' . "\n";
                    build_cat_menu($item[3]);
                    echo '</ul>' . "\n";
                    echo '</li>' . "\n";
                }
            }
        }

        build_cat_menu($header['category_tree']);
    @endphp
</ul>
