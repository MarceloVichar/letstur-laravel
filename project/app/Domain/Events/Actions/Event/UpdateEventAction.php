<?php

namespace App\Domain\Events\Actions\Event;

use App\Domain\Events\Models\Event;

class UpdateEventAction
{
    public function execute(Event $event, EventData $data): Event
    {
        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
            'driverId' => 'driver_id',
            'vehicleId' => 'vehicle_id',
            'tourGuideId' => 'tour_guide_id',
            'tourId' => 'tour_id',
            'departureDateTime' => 'departure_date_time',
            'arrivalDateTime' => 'arrival_date_time',
        ]);

        $event->update($dataArray);

        return $event;
    }
}
