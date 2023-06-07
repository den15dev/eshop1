<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\UserNotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserNotificationController extends Controller
{
    public function index(UserNotificationService $notificationService): View
    {
        $user_id = Auth::id();
        $notifications = $notificationService->get($user_id);

        $unread_num = $notificationService->getUnreadNum($user_id);
        $unread_report = $notificationService->getUnreadReport($unread_num);

        return view('layout.user-notifications', compact(
            'notifications',
            'unread_num',
            'unread_report',
            'user_id'
        ));
    }
}
