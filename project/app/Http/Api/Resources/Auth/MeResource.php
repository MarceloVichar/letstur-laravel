<?php

namespace App\Http\Api\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->roles->pluck('name'),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'company' => $this->whenLoaded('company'),
            'createdAt' => iso8601($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
