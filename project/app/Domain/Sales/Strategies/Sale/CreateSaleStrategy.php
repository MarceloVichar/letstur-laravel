<?php

namespace App\Domain\Sales\Strategies\Sale;

use App\Domain\Events\Actions\Event\UpdateAvailableSeatsAction;
use App\Domain\Events\Models\Event;
use App\Domain\Sales\Actions\EventSale\AttachEventSaleAction;
use App\Domain\Sales\Actions\EventSale\EventSaleData;
use App\Domain\Sales\Actions\Sale\CreateSaleAction;
use App\Domain\Sales\Actions\Sale\SaleData;
use App\Domain\Sales\Actions\Sale\SaleInfoData;
use App\Domain\Sales\Models\Sale;
use Illuminate\Support\Facades\DB;

class CreateSaleStrategy
{
    public function execute(SaleData $data): ?Sale
    {
        try {

            DB::beginTransaction();
            $saleData = SaleInfoData::validateAndCreate($data->toArray());
            $sale = $this->createSale($saleData);

            $this->attachEventSales($data->eventSales->toArray(), $sale);

            DB::commit();

            return $sale;

        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            throw $exception;
        }
    }

    private function createSale(SaleInfoData $data): Sale
    {
        return app(CreateSaleAction::class)
            ->execute($data);
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
}
