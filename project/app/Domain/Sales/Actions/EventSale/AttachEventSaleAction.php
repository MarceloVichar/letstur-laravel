<?php

namespace App\Domain\Sales\Actions\EventSale;

use App\Domain\Events\Models\Event;
use App\Domain\Sales\Models\Sale;

class AttachEventSaleAction
{
    public function execute(EventSaleData $eventSale, Sale $sale, Event $event)
    {
        $dataArray = array_keys_as($eventSale->toArray(), [
            'eventId' => 'event_id',
        ]);

        $eventTotalValueCents = $event?->tour?->price_cents;

        if ($event->available_seats < $dataArray['quantity']) {
            throw new \Exception('Error: Quantity of seats not available.');
        }

        if (!$eventTotalValueCents) {
            throw new \Exception('Error: Event price not found.');
        }

        $dataArray['total_value_cents'] = $eventTotalValueCents * $dataArray['quantity'];
        $dataArray['passengers'] = json_encode($dataArray['passengers']);
        $sale->events()->attach($event->id, $dataArray);
    }
}
