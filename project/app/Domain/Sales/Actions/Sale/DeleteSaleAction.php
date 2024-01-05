<?php

namespace App\Domain\Sales\Actions\Sale;

use App\Domain\Sales\Models\Sale;

class DeleteSaleAction
{
    public function execute(Sale $sale): bool
    {
        $sale->events()->detach();

        return $sale->delete();
    }
}
