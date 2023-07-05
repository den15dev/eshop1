<?php


namespace App\Services\Admin;


class PromoService
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
            'column' => 'image',
            'title' => '',
            'align' => '',
            'is_sortable' => false,
            'is_searchable' => false,
        ],
        [
            'column' => 'name',
            'title' => 'Название',
            'align' => 'start',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'until',
            'title' => 'Дата окончания',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
        [
            'column' => 'is_active',
            'title' => 'Активно',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
    ];
}
