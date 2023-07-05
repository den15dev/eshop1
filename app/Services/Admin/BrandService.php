<?php


namespace App\Services\Admin;


class BrandService
{
    public static array $table_settings = [
        [
            'column' => 'id',
            'title' => 'id',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'name',
            'title' => 'Название',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'slug', // An image with a name by the slug will be output
            'title' => '',
            'align' => '',
            'is_sortable' => false,
            'is_searchable' => false,
        ],
    ];
}
