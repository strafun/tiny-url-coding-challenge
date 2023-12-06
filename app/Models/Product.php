<?php

namespace App\Models;

use App\Interfaces\Cacheable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model implements Cacheable
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'category_id', 'isTop', 'description', 'price'];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value / 100,
            set: fn (string $value) => floor($value) . (round($value, 2) - floor($value)),
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

    public function archive(): static
    {
        $archive = new ProductArchive();
        $archive->id = $this->id;
        $archive->product_archive = $this->getAttributes();
        $archive->save();
        return $this;
    }

    public function getCachedAttributes()
    {
        return [
            'id' => $this->getKey(),
            'name' => $this->name,
            'price' => $this->price,
        ];
    }
}
