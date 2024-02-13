<?php

namespace App\Entity\Enum;

enum TShirtSize: string
{
    case small = 'S';
    case medium = 'M';
    case large = 'L';
    case extraLarge = 'XL';
    case extraExtraLarge = 'XXL';
}
