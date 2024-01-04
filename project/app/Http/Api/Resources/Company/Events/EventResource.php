<?php

namespace App\Http\Api\Resources\Company\Events;

use App\Http\Api\Resources\Company\Records\DriverResource;
use App\Http\Api\Resources\Company\Records\TourGuideResource;
use App\Http\Api\Resources\Company\Records\TourResource;
use App\Http\Api\Resources\Company\Records\VehicleResource;
use App\Http\Api\Resources\Shared\CompanyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'totalSeats' => $this->total_seats,
            'availableSeats' => $this->available_seats,
            'departureDateTime' => output_date_format($this->departure_date_time),
            'arrivalDateTime' => output_date_format($this->arrival_date_time),
            'tourGuideId' => $this->tour_guide_id,
            'tourGuide' => TourGuideResource::make($this->whenLoaded('tourGuide')),
            'vehicleId' => $this->vehicle_id,
            'vehicle' => VehicleResource::make($this->whenLoaded('vehicle')),
            'tourId' => $this->tour_id,
            'tour' => TourResource::make($this->whenLoaded('tour')),
            'driverId' => $this->driver_id,
            'driver' => DriverResource::make($this->whenLoaded('driver')),
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'companyId' => $this->company_id,
            'createdAt' => output_date_format($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
