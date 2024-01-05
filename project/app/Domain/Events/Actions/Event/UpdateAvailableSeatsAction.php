<?php

namespace App\Domain\Events\Actions\Event;

use App\Domain\Events\Models\Event;

class UpdateAvailableSeatsAction
{
    public function execute(Event $event)
    {
        $event->available_seats = $event->total_seats - $this->sales($event);
        $event->update();
    }

    private function sales($event): int
    {
        $data = [];
        foreach ($event->sales as $eventSale) {
            $data[] = $eventSale->pivot->quantity;
        }

        return array_sum($data);
    }
}
