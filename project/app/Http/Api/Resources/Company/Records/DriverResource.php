<?php

namespace App\Http\Api\Resources\Company\Records;

use App\Http\Api\Resources\Shared\CompanyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cnh' => $this->cnh,
            'cnhType' => $this->cnh_type,
            'document' => $this->document,
            'phone' => $this->phone,
            'dateOfBirth' => output_date_format($this->date_of_birth),
            'email' => $this->email,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'companyId' => $this->company_id,
            'createdAt' => output_date_format($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
