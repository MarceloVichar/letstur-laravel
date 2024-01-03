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
            'licensePlate' => 'required|string|min:2|max:255',
            'type' => [
                'required',
                'string',
                (new ValidEnumValue(VehicleTypeEnum::class))->strict(),
            ],
            'model' => 'required|string|min:2|max:255',
            'numberOfSeats' => 'required|integer',
            'ownerName' => 'required|string|min:2|max:255',
            'ownerDocument' => 'required|string|min:2|max:255',
            'ownerPhone' => 'required|string|min:2|max:255',
            'ownerEmail' => ['required', 'email', 'string'],
            'cnhTypeRequired' => [
                'required',
                'string',
                (new ValidEnumValue(CnhTypesEnum::class))->strict(),
            ],
        ];
    }
}
