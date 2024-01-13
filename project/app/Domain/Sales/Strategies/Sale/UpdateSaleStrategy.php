<?php

namespace App\Domain\Sales\Strategies\Sale;

use App\Domain\Events\Actions\Event\UpdateAvailableSeatsAction;
use App\Domain\Events\Models\Event;
use App\Domain\Sales\Actions\EventSale\AttachEventSaleAction;
use App\Domain\Sales\Actions\EventSale\EventSaleData;
use App\Domain\Sales\Actions\Sale\DetachAllEventsAction;
use App\Domain\Sales\Actions\Sale\SaleData;
use App\Domain\Sales\Actions\Sale\SaleInfoData;
use App\Domain\Sales\Actions\Sale\UpdateSaleAction;
use App\Domain\Sales\Actions\Sale\UpdateSaleTotalValueAction;
use App\Domain\Sales\Models\Sale;
use Illuminate\Support\Facades\DB;

class UpdateSaleStrategy
{
    public function execute(Sale $sale, SaleData $data): ?Sale
    {
        try {

            DB::beginTransaction();
            $saleData = SaleInfoData::validateAndCreate($data->toArray());
            $sale = $this->updateSale($sale, $saleData);

            $this->detachAllEventSales($sale);

            $this->attachEventSales($data->eventSales->toArray(), $sale);

            $sale = $this->updateSaleTotalValue($sale);

            DB::commit();


            return $sale;

        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            throw $exception;
        }
    }

    private function updateSale(Sale $sale, SaleInfoData $data): Sale
    {
        return app(UpdateSaleAction::class)
            ->execute($sale, $data);
    }

    private function updateSaleTotalValue(Sale $sale): Sale
    {
        return app(UpdateSaleTotalValueAction::class)
            ->execute($sale);
    }

    private function attachEventSales(array $eventSales, Sale $sale): void
    {
        foreach ($eventSales as $eventSale) {
            $eventSaleData = EventSaleData::validateAndCreate($eventSale);

            $event = Event::findOrFail($eventSaleData->eventId);

            app(AttachEventSaleAction::class)
                ->execute($eventSaleData, $sale, $event);

            app(UpdateAvailableSeatsAction::class)
                ->execute($event);
        }
    }

    private function detachAllEventSales(Sale $sale): void
    {
        $events = $sale->events;

        app(DetachAllEventsAction::class)
            ->execute($sale);

        foreach ($events as $event) {
            app(UpdateAvailableSeatsAction::class)
                ->execute($event);
        }
    }
}
