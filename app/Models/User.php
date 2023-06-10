<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }


    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }


    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }


    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }


    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }


    public function isAdmin(): bool
    {
        if ($this->getAttribute('role') === 'admin' || $this->getAttribute('role') === 'boss') {
            return true;
        }
        return false;
    }


    public function isBoss(): bool
    {
        if ($this->getAttribute('role') === 'boss') {
            return true;
        }
        return false;
    }


    public function getThumbnailAttribute(): string
    {
        $thumbnail = 'menu_user_icon.png';
        if ($this->image) {
            $thumbnail_arr = explode('.', $this->image);
            $thumbnail_arr[count($thumbnail_arr) - 2] .= '_thumbnail';
            $thumbnail = $this->id . '/' . implode('.', $thumbnail_arr);
        }
        return $thumbnail;
    }
}
