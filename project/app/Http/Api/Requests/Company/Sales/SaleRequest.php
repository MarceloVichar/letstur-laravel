<?php

namespace App\Http\Api\Requests\Company\Sales;

use App\Domain\Sales\Rules\DistinctEventIdRule;
use App\Domain\Sales\Rules\EventSalePassengersRule;
use App\Domain\Sales\Rules\EventSaleQuantityRule;
use App\Domain\Sales\Rules\EventSaleQuantityUpdateRule;
use App\Http\Shared\Requests\FormRequest;
use Illuminate\Validation\Rule;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'customer' => 'required|array',
            'customer.name' => 'required|string|min:2|max:255',
            'customer.email' => 'required|email|string|min:2|max:255',
            'customer.document' => 'required|string|min:2|max:255',
            'customer.phone' => 'sometimes|string|min:2|max:255',
            'eventSales' => [
                'required',
                'array',
                'min:1',
                new DistinctEventIdRule($this->input('eventSales'))
            ],
            'eventSales.*.eventId' => [
                'required',
                'integer',
                Rule::exists('events', 'id')
                    ->where('company_id', current_user()->company_id)
                    ->withoutTrashed()
            ],
            'eventSales.*.passengers' => [
                'required',
                'array',
                $this->eventSalePassengersQuantity(),
            ],
            'eventSales.*.passengers.*.name' => 'required|string|min:2|max:255',
            'eventSales.*.passengers.*.document' => 'required|string|min:2|max:255',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['eventSales.*.quantity'][] = $this->eventSaleRangeQuantityUpdate();
        } else {
            $rules['eventSales.*.quantity'][] = $this->eventSaleRangeQuantity();
        }

        return $rules;
    }

    function eventSaleRangeQuantity()
    {
        return function ($attribute, $value, $fail) {
            $segments = explode('.', $attribute);
            $index = $segments[1];
            $eventId = $this->input("eventSales.{$index}.eventId");

            $rule = new EventSaleQuantityRule($eventId);

            $rule->validate($attribute, $value, $fail);
        };
    }

    function eventSaleRangeQuantityUpdate()
    {
        return function ($attribute, $value, $fail) {
            $segments = explode('.', $attribute);
            $index = $segments[1];
            $eventId = $this->input("eventSales.{$index}.eventId");

            $rule = new EventSaleQuantityUpdateRule($eventId, $this->route('sale'));

            $rule->validate($attribute, $value, $fail);
        };
    }

    function eventSalePassengersQuantity()
    {
        return function ($attribute, $value, $fail) {
            $segments = explode('.', $attribute);
            $index = $segments[1];
            $quantity = $this->input("eventSales.{$index}.quantity");

            $rule = new EventSalePassengersRule($quantity);

            $rule->validate($attribute, $value, $fail);
        };
    }
}
