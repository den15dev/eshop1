<?php


namespace App\Services\Admin;


use App\Models\Notification;
use App\Models\Order;
use App\Models\Shop;
use Illuminate\Support\Carbon;

class OrderService
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
            'column' => 'status',
            'title' => 'Статус',
            'align' => '',
            'is_sortable' => true,
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
            'column' => 'delivery_type',
            'title' => 'Способ получения',
            'align' => '',
            'is_sortable' => false,
            'is_searchable' => false,
        ],
        [
            'column' => 'total_cost',
            'title' => 'Стоимость, ₽',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
    ];


    public function sendSiteNotification(Order $order)
    {
        if ($order->user_id) {
            $note_title = match ($order->status) {
                'accepted' => 'Заказ №' . $order->id . ' принят.',
                'ready' => 'Заказ №' . $order->id . ' готов к получению.',
                'sent' => 'Заказ №' . $order->id . ' отправлен.',
                default => '',
            };

            $shop_address = '';
            if ($order->status === 'ready') {
                $shop_address = Shop::find($order->shop_id)->address;
            }

            $note_message = match ($order->status) {
                'accepted' => 'Заказ №' . $order->id . ' принят, товары готовятся к ' . ($order->delivery_type === 'delivery' ? 'отправке' : 'выдаче') . '. Пожалуйста, ожидайте уведомления.',
                'ready' => 'Заказ №' . $order->id . ' ожидает получения в магазине по адресу: ' . $shop_address . '. Товары будут доступны для получения до ' . Carbon::parse($order->updated_at)->addDays(2)->isoFormat('D MMMM YYYY, H:mm') . '.',
                'sent' => 'Заказ №' . $order->id . ' передан в службу доставки. Пожалуйста, ожидайте звонка курьера.',
                default => '',
            };

            if ($note_title) {
                $notification = new Notification();
                $notification->user_id = $order->user_id;
                $notification->title = $note_title;
                $notification->message = $note_message;
                $notification->save();
            }
        }
    }
}
