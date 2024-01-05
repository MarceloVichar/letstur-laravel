<?php

namespace App\Domain\Sales\Enums;

use App\Support\Enum;

class SaleStatusEnum extends Enum
{
    public const PENDING = 'pending';

    public const CONFIRMED = 'confirmed';

    public const CANCELED = 'canceled';
}
