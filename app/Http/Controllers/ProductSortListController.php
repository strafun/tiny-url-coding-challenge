<?php

namespace App\Http\Controllers;

use App\Enums\SortingDirection;
use App\Enums\SortingFields;
use App\Services\CategoryService;
use App\Services\ProductSortListService;
use Inertia\Inertia;

class ProductSortListController extends Controller
{
    public function __invoke(
        ProductSortListService $productSortListService,
        CategoryService $categoryService,
        ?SortingFields $sort = SortingFields::NAME,
        ?SortingDirection $direction = SortingDirection::ASC,

    ): \Inertia\Response
    {
        $products = $productSortListService->getProductSortList($sort, $direction);
        $category_ids = $products->pluck('category_id');
        $categories =  $categoryService->getCachedByIds($category_ids);

        return Inertia::render('Product/SortList',
            [
                'products' => $products,
                'categories' => $categories,
                'sort' => $sort->value . $direction->value
            ]
        );
    }
}
