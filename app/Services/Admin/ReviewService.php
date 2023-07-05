<?php


namespace App\Services\Admin;


class ReviewService
{
    public static array $table_settings = [
        [
            'column' => 'id',
            'title' => 'id',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
        [
            'column' => 'user_id',
            'title' => 'Пользователь',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'product_id',
            'title' => 'Товар',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'pros',
            'title' => 'Преимущества',
            'align' => 'start',
            'is_sortable' => false,
            'is_searchable' => false,
        ],
        [
            'column' => 'cons',
            'title' => 'Недостатки',
            'align' => 'start',
            'is_sortable' => false,
            'is_searchable' => false,
        ],
        [
            'column' => 'comnt',
            'title' => 'Комментарий',
            'align' => 'start',
            'is_sortable' => false,
            'is_searchable' => false,
        ],
        [
            'column' => 'created_at',
            'title' => 'Дата',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
    ];
}
