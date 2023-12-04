<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    const INITIAL_ID = 1000;

    public function createCategory(array $dataToSave):void
    {
        if (empty($dataToSave['title'])) {
            throw new \Exception('The title should be provided', 500);
        }

        $newId = $this->calculateNewIdInBeetwen($dataToSave['title']);

        Category::create(['id' => $newId, ...$dataToSave]);
    }

    private function calculateNewIdInBeetwen($title)
    {
        $nextCategory =  Category::select('id')->where('title', '>', $title)->first();
        $previousCategory =  Category::select('id')->where('title', '<', $title)->first();

        if (empty($nextCategory) && empty($previousCategory)) {
            return self::INITIAL_ID;
        }

        return floor((($nextCategory->id ?? ($previousCategory->id + 1000)) + $previousCategory->id ?? 0)/2);
    }
}
