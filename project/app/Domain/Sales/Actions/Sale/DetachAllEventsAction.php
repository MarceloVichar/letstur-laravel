<?php

namespace App\Domain\Sales\Actions\Sale;

use App\Domain\Sales\Models\Sale;

class DetachAllEventsAction
{
    public function execute(Sale $sale)
    {
        return $sale->events()->detach();
    }
}
