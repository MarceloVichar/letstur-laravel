<?php

namespace App\Domain\Sales\Actions\Sale;

use App\Domain\Sales\Models\Sale;

class UpdateSaleTotalValueAction
{
    public function execute(Sale $sale): Sale
    {
        $totalValue = 0;
        foreach ($sale->events as $event) {
            $totalValue += $event->pivot->total_value_cents;
        }

        return tap($sale)
            ->update([
                'total_value_cents' => $totalValue,
            ]);
    }
}
