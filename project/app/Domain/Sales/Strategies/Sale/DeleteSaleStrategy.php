<?php

namespace App\Domain\Sales\Strategies\Sale;

use App\Domain\Events\Actions\Event\UpdateAvailableSeatsAction;
use App\Domain\Sales\Actions\Sale\DeleteSaleAction;
use App\Domain\Sales\Actions\Sale\DetachAllEventsAction;
use App\Domain\Sales\Models\Sale;
use Illuminate\Support\Facades\DB;

class DeleteSaleStrategy
{
    public function execute(Sale $sale): bool
    {
        try {
            DB::beginTransaction();

            $events = $sale->events;

            app(DetachAllEventsAction::class)
                ->execute($sale);

            foreach ($events as $event) {
                app(UpdateAvailableSeatsAction::class)
                    ->execute($event);
            }

            $deleted = app(DeleteSaleAction::class)
                ->execute($sale);

            DB::commit();

            return $deleted;
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            throw $exception;
        }
    }
}
