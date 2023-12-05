<?php

namespace App\Models;

use App\Interfaces\Cacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements Cacheable
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ['id', 'title'];

    public function getCachedAttributes(): array
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->title
        ];
    }
}
