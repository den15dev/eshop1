<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\LogService;
use Illuminate\View\View;

class LogController extends Controller
{
    public function index(LogService $logService): View
    {
        $logs = $logService->getEventsLog();

        return view('admin.logs', compact('logs'));
    }
}
