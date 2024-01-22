<?php

namespace App\Http\Api\Resources\Company\Records;

use App\Http\Api\Resources\Shared\CompanyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'roundTrip' => $this->round_trip,
            'priceCents' => $this->price_cents,
            'note' => $this->note,
            'color' => $this->tourType->color,
            'localeId' => $this->locale_id,
            'tourTypeId' => $this->tour_type_id,
            'locale' => LocaleResource::make($this->whenLoaded('locale')),
            'tourType' => TourTypeResource::make($this->whenLoaded('tourType')),
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'companyId' => $this->company_id,
            'createdAt' => output_date_format($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
