<?php

namespace App\Services;

use App\Enums\SortingDirection;
use App\Enums\SortingFields;
use App\Models\Product;

class ProductSortListService
{
    public function getProductSortList(SortingFields $sortField, SortingDirection $direction)
    {
        return Product::orderBy($sortField->field(), $direction->direction())
            ->cursorPaginate(config('product.page_size'));
    }
}
