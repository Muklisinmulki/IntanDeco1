<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Catalog extends Model
{
    protected $fillable = ['name', 'code', 'category_id', 'image'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
