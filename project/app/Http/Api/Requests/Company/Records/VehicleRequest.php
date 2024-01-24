<?php

namespace App\Http\Api\Requests\Company\Records;

use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Records\Enums\VehicleTypeEnum;
use App\Domain\Shared\Rules\ValidEnumValue;
use App\Http\Shared\Requests\FormRequest;

class VehicleRequest extends FormRequest
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
            'licensePlate' => 'required|string|regex:/^[a-zA-Z]{3}\d[a-zA-Z0-9]\d{2}$/',
            'type' => [
                'required',
                'string',
                (new ValidEnumValue(VehicleTypeEnum::class))->strict(),
            ],
            'model' => 'required|string|min:2|max:255',
            'numberOfSeats' => 'required|integer|min:1|max:150',
            'ownerName' => 'required|string|min:2|max:255',
            'ownerDocument' => 'required|string|digits_between:11,14',
            'ownerPhone' => 'required|string|digits_between:10,11',
            'ownerEmail' => ['required', 'email', 'string'],
            'cnhTypeRequired' => [
                'required',
                'string',
                (new ValidEnumValue(CnhTypesEnum::class))->strict(),
            ],
        ];
    }
}
