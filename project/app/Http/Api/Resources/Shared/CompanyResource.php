<?php

namespace App\Http\Api\Resources\Shared;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'tradingName' => $this->trading_name,
            'cnpj' => $this->cnpj,
            'ie' => $this->ie,
            'phone' => $this->phone,
            'secondaryPhone' => $this->secondary_phone,
            'email' => $this->email,
            'createdAt' => iso8601($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
