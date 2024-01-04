<?php

namespace App\Http\Api\Resources\Company\Records;

use App\Http\Api\Resources\Shared\CompanyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LocaleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'zipCode' => $this->zip_code,
            'street' => $this->street,
            'number' => $this->number,
            'complement' => $this->complement,
            'district' => $this->district,
            'city' => $this->city,
            'uf' => $this->uf,
            'responsibleName' => $this->responsible_name,
            'responsiblePhone' => $this->responsible_phone,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'companyId' => $this->company_id,
            'createdAt' => output_date_format($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
