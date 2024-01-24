<?php

namespace App\Http\Api\Resources\Company\Sales;

use App\Http\Api\Resources\Company\Events\EventResource;
use App\Http\Api\Resources\Shared\CompanyResource;
use App\Http\Api\Resources\Shared\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer' => [
                'name' => $this->customer_name,
                'document' => $this->customer_document,
                'email' => $this->customer_email,
                'phone' => $this->customer_phone,
            ],
            'status' => $this->status,
            'voucher' => $this->voucher,
            'totalValueCents' => $this->total_value_cents,
            'seller' => UserResource::make($this->whenLoaded('seller')),
            'sellerId' => $this->seller_id,
            'events' => $this->whenLoaded('events', function () {
                return $this->events->map(function ($event) {
                    return [
                        'quantity' => $event->pivot->quantity,
                        'totalValueCents' => $event->pivot->total_value_cents,
                        'passengers' => json_decode($event->pivot->passengers),
                        'event' => EventResource::make($event),
                    ];
                });
            }),
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'companyId' => $this->company_id,
            'createdAt' => output_date_format($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
