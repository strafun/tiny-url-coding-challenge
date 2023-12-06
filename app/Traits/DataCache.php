<?php

namespace App\Traits;

use App\Interfaces\Cacheable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait DataCache
{
    abstract private function getCacheKey(): string;
    public function getCached(): Collection
    {
        return collect(Cache::get($this->getCacheKey(), []));
    }

    private function addToCache(Cacheable $model): void
    {
        $cached = Cache::get($this->getCacheKey(), []);
        $cached[$model->getKey()] = $model->getCachedAttributes();
        Cache::set($this->getCacheKey(), $cached);
    }

    private function removeFromCache(int $key): void
    {
        $topProducts = Cache::get($this->getCacheKey(), []);
        unset($topProducts[$key]);
        Cache::set($this->getCacheKey(), $topProducts);
    }

    public function getCachedByIds(Collection $ids): Collection
    {
        return collect(Cache::get($this->getCacheKey(), []))->only($ids);
    }
}
