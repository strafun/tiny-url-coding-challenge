<?php

namespace App\Jobs;

use App\Models\Product;
use App\Services\ProductTopService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly Product $product,
        private readonly array $attributes
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(ProductTopService $productTopService): void
    {
        $this->product->fill($this->attributes)->save();
        $this->product->productDetails()->updateOrCreate(['description' => $this->attributes['description']]);

        $productTopService->handle($this->product, $this->attributes['isTop']);
    }
}
