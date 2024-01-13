<?php

namespace App\Domain\Sales\Actions\Sale;

use App\Domain\Sales\Models\Sale;

class DetachAllEventsAction
{
    public function execute(Sale $sale)
    {
        $sale->events()->detach();
        $sale->refresh();
    }
}
