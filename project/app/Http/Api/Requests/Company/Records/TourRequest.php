<?php

namespace App\Http\Api\Requests\Company\Records;

use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Shared\Rules\ValidEnumValue;
use App\Http\Shared\Requests\FormRequest;
use Illuminate\Validation\Rule;

class TourRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'priceCents' => 'required|integer|min:0',
            'roundTrip' => 'required|integer|min:0',
            'note' => 'sometimes|string|min:2|max:255',
            'localeId' => [
                'required',
                Rule::exists('locales', 'id')
                    ->where('company_id', current_user()->company_id)
                    ->withoutTrashed()],
            'tourTypeId' => [
                'required',
                Rule::exists('tour_types', 'id')
                    ->where('company_id', current_user()->company_id)
                    ->withoutTrashed()],
        ];
    }
}
