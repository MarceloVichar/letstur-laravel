<?php

namespace App\Http\Api\Requests\Company\Records;

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
            'zipCode' => 'nullable|string|min:8|max:8',
            'street' => 'required|string|min:2|max:255',
            'number' => 'nullable|string|min:1|max:255',
            'complement' => 'nullable|string|min:2|max:255',
            'district' => 'nullable|string|min:2|max:255',
            'city' => 'required|string|min:2|max:255',
            'uf' => 'required|string|min:2|max:2',
            'responsibleName' => 'required|string|min:2|max:255',
            'responsiblePhone' => 'required|string|min:2|max:255',
        ];
    }
}
