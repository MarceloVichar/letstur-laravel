<?php

namespace App\Domain\Sales\Actions\Sale;

use App\Domain\Sales\Enums\SaleStatusEnum;
use App\Domain\Sales\Models\Sale;

class ConfirmSaleAction
{
    public function execute(Sale $sale): Sale
    {
        return tap($sale)
            ->update([
                'status' => SaleStatusEnum::CONFIRMED,
            ]);
    }
}
