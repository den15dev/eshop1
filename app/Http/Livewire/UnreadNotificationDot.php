<?php

namespace App\Http\Livewire;

use App\Services\UserNotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UnreadNotificationDot extends Component
{
    public string $type;
    public int $unread_num = 0;

    protected $listeners = ['unreadUpdated'];

    public function mount()
    {
        $this->unread_num = (new UserNotificationService())->getUnreadNum(Auth::id());
    }

    public function unreadUpdated(int $new_num)
    {
        $this->unread_num = $new_num;
    }

    public function render()
    {
        return view('livewire.unread-notification-dot');
    }
}
