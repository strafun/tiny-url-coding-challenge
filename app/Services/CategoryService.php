<?php

namespace App\Services;

use App\Models\Category;
use App\Traits\DataCache;

class CategoryService
{
    use DataCache;

    const INITIAL_ID = 1000;
    const CACHED_KEY = 'categories';

    private function getCacheKey(): string
    {
        return self::CACHED_KEY;
    }

    public function createCategory(array $dataToSave):void
    {
        if (empty($dataToSave['title'])) {
            throw new \Exception('The title should be provided', 500);
        }

        $newId = $this->calculateNewIdInBeetwen($dataToSave['title']);

        $category =  new Category(['id' => $newId, ...$dataToSave]);
        $category->save();
        $this->addToCache($category);
    }

    private function calculateNewIdInBeetwen($title)
    {
        $nextCategory =  Category::select('id')->where('title', '>', $title)->orderBy('id')->first();
        $previousCategory =  Category::select('id')->where('title', '<', $title)->orderBy('id', 'DESC')->first();

        if (empty($nextCategory) && empty($previousCategory)) {
            return self::INITIAL_ID;
        }

        return floor((($nextCategory->id ?? ($previousCategory->id + 1000)) + $previousCategory->id ?? 0)/2);
    }
}
