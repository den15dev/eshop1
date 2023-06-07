<?php

namespace App\Http\Livewire;

use App\Services\UserNotificationService;
use Livewire\Component;

class UnreadNotificationHead extends Component
{
    public int $user_id;
    public int $num;
    public string $report;

    protected $listeners = ['markAsRead'];

    public function markAllAsRead()
    {
        $notificationService = new UserNotificationService();
        $notificationService->markAllAsRead($this->user_id);
        $this->emit('reloadPageByJS');
    }

    public function markAsRead(int $notification_id)
    {
        $notificationService = new UserNotificationService();
        $this->num = $notificationService->markAsRead($notification_id, $this->user_id);
        $this->report = $notificationService->getUnreadReport($this->num);
        $this->emit('unreadUpdated', $this->num);
    }

    public function render()
    {
        return view('livewire.unread-notification-head');
    }
}
