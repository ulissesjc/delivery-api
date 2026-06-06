<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftCascadeTrait, SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
    ];

    protected $softCascade = ['products'];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class)->withTrashed();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
