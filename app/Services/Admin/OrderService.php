<?php


namespace App\Services\Admin;


class OrderService
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
            'column' => 'status',
            'title' => 'Статус',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
        [
            'column' => 'name',
            'title' => 'Имя',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'delivery_type',
            'title' => 'Способ получения',
            'align' => '',
            'is_sortable' => false,
            'is_searchable' => false,
        ],
        [
            'column' => 'total_cost',
            'title' => 'Стоимость, ₽',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
    ];
}
