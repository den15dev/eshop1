<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use HasFactory;


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }


    protected function convertTerm(string $term_id)
    {
        $term = 'дней';
        switch ($term_id) {
            case 'weeks':
                $term = 'недель'; break;
            case 'months':
                $term = 'месяцев'; break;
            case 'years':
                $term = 'лет'; break;
        }

        return 'несколько '.$term;
    }


    protected function term(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $this->convertTerm($value),
        );
    }
}
