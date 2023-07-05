@extends('admin.layout')

@section('page_title', 'Категории - Администрирование')

@section('main_content')
    <h2 class="mb-4">Категории</h2>

    <div class="d-md-flex flex-row-reverse justify-content-between">
        <a href="{{ route('admin.categories.create') }}" class="btn2 btn2-red mb-4 adm_add_btn" style="height: 40px">
            <span class="bi-plus"></span>
            Добавить категорию
        </a>

        <ul id="category_tree">
            @php
                $nest_level = 0;

                function build_cat_menu($menu_arr, $nest_level) {
                    foreach ($menu_arr as $item) {
                        $products_num = $item[3] ? ' <span class="lightgrey_text" style="font-size: 14px">' . $item[3] . '</span>' : '';
                        $grey_text = $nest_level ? ' grey-submenu' : '';

                        if (count($item) < 5) {

                            echo '<li>' . "\n";
                            echo '<a href="' . route('admin.categories.edit', $item[0]) . '" class="dd-menu-btn' . $grey_text . '" style="padding-left: ' . (15 + 20*$nest_level) . 'px">' . "\n";
                            echo $item[1] . $products_num . "\n";
                            echo '</a>' . "\n";
                            echo '</li>' . "\n";

                        } else {

                            echo '<li class="sub-menu">' . "\n";
                            echo '<a href="' . route('admin.categories.edit', $item[0]) . '" class="sub-menu-btn' . $grey_text . '" style="padding-left: ' . (15 + 20*$nest_level) . 'px">' . "\n";
                            echo $item[1] . $products_num . "\n";
                            echo '</a>' . "\n";
                            echo '<ul>' . "\n";

                            $nest_level++;
                            build_cat_menu($item[4], $nest_level);
                            $nest_level--;

                            echo '</ul>' . "\n";
                            echo '</li>' . "\n";
                        }
                    }
                }

                build_cat_menu($category_tree, $nest_level);
            @endphp
        </ul>
    </div>
@endsection
