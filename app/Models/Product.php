<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value / 100,
            set: fn (string $value) => $value * 100,
        );
    }

    public function productDetails(): HasOne
    {
        return $this->hasOne(ProductDetails::class, 'id', 'id');
    }

    public function productTop(): HasOne
    {
        return $this->hasOne(ProductTop::class, 'id', 'id');
    }
}
