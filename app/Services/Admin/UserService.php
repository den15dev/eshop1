<?php


namespace App\Services\Admin;


use App\Models\User;

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


    public function toggleIsActive(int $user_id, int $is_active)
    {
        if (in_array($is_active, [0, 1])) {
            User::where('id', $user_id)->update(['is_active' => $is_active]);
            return 'ok';
        }

        return abort(500, 'Incorrect is_active value provided.');
    }
}
