<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    protected $except = [
        'vis', // Track if it is not a first visit
        'rct_viewed', // Recently viewed product ids
        'layout', // Products layout settings
        'ord', // List of order ids
        'compare', // List or product ids for comparison
        'fav', // List of favorite product ids
        'tbl_ppage', // Number of table rows per page in admin panel
    ];
}
