<?php

namespace App\Http\Api\Requests\Company\Records;

use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Shared\Rules\ValidEnumValue;
use App\Http\Shared\Requests\FormRequest;

class DriverRequest extends FormRequest
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
            'cnh' => 'required|string|min:2|max:255',
            'cnhType' => [
                'required',
                'string',
                (new ValidEnumValue(CnhTypesEnum::class))->strict(),
            ],
            'document' => 'required|string|digits_between:11,14',
            'email' => ['required', 'email', 'string'],
            'phone' => 'required|string|digits_between:10,11',
            'dateOfBirth' => 'required|string|date_format:Y-m-d|before:' . now()->subYears(18)->format('Y-m-d'),
        ];
    }
}
