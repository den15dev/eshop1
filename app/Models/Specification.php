<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specification extends Model
{
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('id', 'spec_value');
    }
}
