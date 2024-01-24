<?php

namespace App\Http\Api\Resources\Company\Sales;

use Illuminate\Http\Resources\Json\JsonResource;

class EventSaleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'totalValueCents' => $this->total_value_cents,
            'eventId' => $this->event_id,
            'createdAt' => output_date_format($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
