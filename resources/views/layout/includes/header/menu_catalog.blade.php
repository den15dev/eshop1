{{-- ---------- Catalog menu version 1 ----------- --}}

{{--<ul class="dropdown-menu">
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
</ul>--}}


{{-- ---------- Catalog menu version 2 ----------- --}}

<ul class="dropdown-menu" id="accordion_dropdown" style="padding-left: 0">
    @php
        $nest_level = 0;

        function build_cat_menu($menu_arr, $nest_level) {
            foreach ($menu_arr as $item) {
                $products_num = $item[2] ? ' <span class="lightgrey_text" style="font-size: 14px">' . $item[2] . '</span>' : '';
                $grey_text = $nest_level ? '; color: #787878;' : '';
                if (count($item) < 4) {

                    echo '<li><a href="' . route('category', [$item[1]]) . '" class="dd-menu-btn" style="padding-left: ' . (15 + 8*$nest_level) . 'px' . $grey_text . '">' . $item[0] . $products_num . '</a></li>' . "\n";

                } else {

                    echo '<li class="sub-menu">' . "\n";
                    echo '<div class="sub-menu-btn" style="padding-left: ' . (15 + 8*$nest_level) . 'px' . $grey_text . '">' . "\n";
                    echo $item[0] . $products_num . "\n";
                    echo '</div>' . "\n";
                    echo '<ul>' . "\n";

                    $nest_level++;
                    build_cat_menu($item[3], $nest_level);
                    $nest_level--;

                    echo '</ul>' . "\n";
                    echo '</li>' . "\n";

                }
            }
        }

        build_cat_menu($header['category_tree'], $nest_level);
    @endphp
</ul>
