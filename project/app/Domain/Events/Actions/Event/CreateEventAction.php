<?php

namespace App\Domain\Events\Actions\Event;

use App\Domain\Events\Models\Event;
use App\Domain\Records\Models\Vehicle;

class CreateEventAction
{
    public function execute(EventData $data): Event
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

        $vehicle = Vehicle::find($dataArray['vehicle_id']);

        $dataArray['total_seats'] = $vehicle['number_of_seats'];
        $dataArray['available_seats'] = $vehicle['number_of_seats'];

        return app(Event::class)
            ->create($dataArray);
    }
}
