<?php

namespace App\Http\Api\Resources\Company\Records;

use App\Http\Api\Resources\Shared\CompanyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'licensePlate' => $this->license_plate,
            'type' => $this->type,
            'model' => $this->model,
            'numberOfSeats' => $this->number_of_seats,
            'cnhTypeRequired' => $this->cnh_type_required,
            'ownerName' => $this->owner_name,
            'ownerDocument' => $this->owner_document,
            'ownerPhone' => $this->owner_phone,
            'ownerEmail' => $this->owner_email,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'companyId' => $this->company_id,
            'createdAt' => output_date_format($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
