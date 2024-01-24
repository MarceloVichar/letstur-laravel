<?php

namespace App\Domain\Events\Actions\Event;

use App\Domain\Events\Models\Event;
use Carbon\Carbon;

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

        $dataArray['departure_date_time'] = Carbon::parse($dataArray['departure_date_time'])->toDateTimeString();
        $dataArray['arrival_date_time'] = Carbon::parse($dataArray['arrival_date_time'])->toDateTimeString();

        $event->update($dataArray);

        return $event;
    }
}
