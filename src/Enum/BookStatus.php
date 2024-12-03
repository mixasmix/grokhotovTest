<?php

declare(strict_types = 1);

namespace App\Enum;

enum BookStatus: string
{
    case PUBLISH = 'PUBLISH';
    case MEAP = 'MEAP';
}
