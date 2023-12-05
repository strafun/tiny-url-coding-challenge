<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductArchive extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'products_archive';

    protected $casts = [
        'product_archive' => 'array'
    ];

}
