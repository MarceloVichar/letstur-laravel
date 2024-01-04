<?php

namespace App\Http\Api\Requests\Company\Records;

use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Shared\Rules\ValidEnumValue;
use App\Http\Shared\Requests\FormRequest;

class LocaleRequest extends FormRequest
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
            'zipCode' => 'required|string|min:8|max:8',
            'street' => 'required|string|min:2|max:255',
            'number' => 'sometimes|string|min:1|max:255',
            'complement' => 'sometimes|string|min:2|max:255',
            'district' => 'sometimes|string|min:2|max:255',
            'city' => 'required|string|min:2|max:255',
            'uf' => 'required|string|min:2|max:2',
            'responsibleName' => 'required|string|min:2|max:255',
            'responsiblePhone' => 'required|string|min:2|max:255',
        ];
    }
}
