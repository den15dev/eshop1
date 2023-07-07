<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->has('service') && $request->has('action')) {
            $serviceClass = 'App\\Services\\Admin\\' . ucfirst($request->query('service')) . 'Service';
            $service = new $serviceClass();
            $action = camel_case($request->query('action'));

            if (method_exists($service, $action)) {
                $arguments = $request->query();
                unset($arguments['service']);
                unset($arguments['action']);

                return call_user_func_array(array($service, $action), $arguments);
            }
        }

        return response(404);
    }
}
