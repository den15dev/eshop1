<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Specification extends Model
{
    protected $guarded = [];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('id', 'spec_value');
    }
}
