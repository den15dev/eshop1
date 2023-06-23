<?php

namespace App\Models;

use App\Services\Site\CategoryService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'images' => 'array',
    ];

    protected $appends = ['category_slug'];



    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }


    public function specifications(): BelongsToMany
    {
        return $this->belongsToMany(Specification::class)->withPivot('id', 'spec_value');
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }


    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }


    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }



    public function scopeDiscount(Builder $query): void
    {
        $query->where('discount_prc', '>', 0)
            ->orderBy('discount_prc', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10);
    }


    public function scopePopular(Builder $query): void
    {
        $query->where('rating', '>', '3')->orderBy('vote_num', 'desc')->limit(10);
    }


    public function getCategorySlugAttribute()
    {
        return (new CategoryService())->getCategories()->firstWhere('id', $this->category_id)->slug;
    }
}
