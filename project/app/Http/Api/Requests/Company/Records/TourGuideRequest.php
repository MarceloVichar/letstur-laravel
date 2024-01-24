<?php

namespace App\Http\Api\Requests\Company\Records;

use App\Http\Shared\Requests\FormRequest;

class TourGuideRequest extends FormRequest
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
            'document' => 'required|string|min:2|max:255',
            'email' => ['required', 'email', 'string'],
            'phone' => 'required|string|min:2|max:255',
        ];
    }
}
