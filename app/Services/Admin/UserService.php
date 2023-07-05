<?php


namespace App\Services\Admin;


class UserService
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
            'title' => 'Имя',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'role',
            'title' => 'Роль',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
        [
            'column' => 'email',
            'title' => 'Email',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => true,
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
