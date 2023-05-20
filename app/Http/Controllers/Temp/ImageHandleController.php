<?php

namespace App\Http\Controllers\Temp;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Http\Response;

class ImageHandleController extends Controller
{
    public function handle(): Response
    {
        $source_dir = storage_path('app/public/images/products/temp/orig');
        $out_dir = storage_path('app/public/images/products/temp');

        set_time_limit(120);

        $num_handled = ImageService::seedProductFolder($source_dir, $out_dir, [600, 242, 80]);

        if ($num_handled) {
            return new Response($num_handled . ' images has been handled successfully.');
        }

        return new Response('Something went wrong');
    }
}
