<?php

namespace App\Services;

use App\Interfaces\Cacheable;
use App\Models\Product;
use App\Traits\DataCache;
use Illuminate\Support\Facades\DB;

class ProductTopService
{
    use DataCache;

    const CACHED_KEY = 'top_products';

    private function getCacheKey(): string
    {
        return self::CACHED_KEY;
    }
    public function handle(Product $product, bool $isTop): void
    {
        if ($isTop && empty($product->productTop)) {
            $product->productTop()->create();
            $this->addToCache($product);
        } else {
            $product->productTop()->delete();
            $this->removeFromCache($product->getKey());
        }
    }
}
