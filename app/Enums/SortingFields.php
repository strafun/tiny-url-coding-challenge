<?php

namespace App\Enums;

enum SortingFields: string
{
    case CATEGORY = 'category';
    case NAME = 'name';
    case PRICE = 'price';

    public function field(): string
    {
        return match($this)
        {
            self::CATEGORY => 'category_id',
            self::NAME => 'name',
            self::PRICE => 'price',
        };
    }
}
