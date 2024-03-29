<?php

namespace App\Http\Api\Requests\Company\Records;

use App\Http\Shared\Requests\FormRequest;

class TourTypeRequest extends FormRequest
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
            'color' => [
                'nullable',
                'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i',
            ],
            'isExclusive' => 'required|boolean',
            'isTransfer' => 'required|boolean',
        ];
    }
}
