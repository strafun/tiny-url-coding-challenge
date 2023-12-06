<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Jobs\CreateProduct;
use App\Models\Product;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $products = Product::select('id', 'name')->orderBy('id')->simpleFastPaginate(config('product.crud_page_size'));
        return Inertia::render('Product/CRUDList', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategoryService $categoryService): \Inertia\Response
    {
        return Inertia::render('Product/Form', [
            'product' => new Product(),
            'categories' => $categoryService->getCached(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        CreateProduct::dispatch(new Product(), $request->all());

        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): \Inertia\Response
    {
        return Inertia::render('Product/View',
            [
                'product' => new ProductResource($product->load(['productDetails', 'productTop'])),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, CategoryService $categoryService): \Inertia\Response
    {
        return Inertia::render('Product/Form', [
            'product' => new ProductResource($product),
            'categories' => $categoryService->getCached(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        CreateProduct::dispatch($product, $request->all());
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        DB::transaction(fn() => $product->archive()->delete());
        return redirect('/products');
    }
}
