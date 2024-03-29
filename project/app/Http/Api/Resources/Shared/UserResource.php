<?php

namespace App\Http\Api\Resources\Shared;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->whenLoaded('roles', function () {
                return $this->roles->pluck('name');
            }),
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'companyId' => $this->company_id,
            'createdAt' => iso8601($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
