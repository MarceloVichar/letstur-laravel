<?php

namespace App\Domain\Events\Actions\Event;

use App\Domain\Events\Models\Event;
use App\Domain\Records\Models\Vehicle;
use Carbon\Carbon;

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

        $vehicle = app(Vehicle::class)->find($dataArray['vehicle_id']);

        $dataArray['total_seats'] = $vehicle['number_of_seats'];
        $dataArray['available_seats'] = $vehicle['number_of_seats'];
        $dataArray['departure_date_time'] = Carbon::parse($dataArray['departure_date_time'])->toDateTimeString();
        $dataArray['arrival_date_time'] = Carbon::parse($dataArray['arrival_date_time'])->toDateTimeString();

        return app(Event::class)
            ->create($dataArray);
    }
}
