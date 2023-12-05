<?php

namespace App\Enums;

enum SortingDirection: string
{
    case ASC = '';
    case DESC = 'desc';

    public function direction(): string
    {
        return match($this)
        {
            self::ASC => 'ASC',
            self::DESC => 'DESC',
        };
    }
}
