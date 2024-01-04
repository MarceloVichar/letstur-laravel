<?php

namespace App\Http\Api\Requests\Company\Events;

use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Shared\Rules\ValidEnumValue;
use App\Http\Shared\Requests\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
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
        return [
            'departureDateTime' => 'required|date|after:now',
            'arrivalDateTime' => 'required|date|after:departureDateTime',
            'driverId' => [
                'required',
                Rule::exists('drivers', 'id')
                    ->where('company_id', current_user()->company_id)
                    ->withoutTrashed()],
            'tourId' => [
                'required',
                Rule::exists('tours', 'id')
                    ->where('company_id', current_user()->company_id)
                    ->withoutTrashed()],
            'vehicleId' => [
                'required',
                Rule::exists('vehicles', 'id')
                    ->where('company_id', current_user()->company_id)
                    ->withoutTrashed()],
            'tourGuideId' => [
                'required',
                Rule::exists('tour_guides', 'id')
                    ->where('company_id', current_user()->company_id)
                    ->withoutTrashed()],
        ];
    }
}
