<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $guarded = [];


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }


    public function getStatusStrAttribute()
    {
        return match ($this->status) {
            'new' => 'новый',
            'accepted' => 'принят',
            'ready' => 'готов к получению',
            'sent' => 'отправлен',
            'completed' => 'завершён',
            'cancelled' => 'отменён',
            default => '',
        };
    }

    public function getDeliveryTypeStrAttribute()
    {
        return match ($this->delivery_type) {
            'delivery' => 'доставка',
            'self' => 'самовывоз',
            default => '',
        };
    }

    public function getPaymentMethodStrAttribute()
    {
        return match ($this->payment_method) {
            'online' => 'онлайн',
            'card' => 'банковской картой',
            'cash' => 'наличными',
            'shop' => 'в магазине',
            default => '',
        };
    }
}
