<?php

namespace App\Http\Api\Requests\Admin;

use App\Http\Shared\Requests\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'tradingName' => 'required|string|min:2|max:255',
            'cnpj' => 'required|string|min:2|max:255',
            'ie' => 'sometimes|string|min:2|max:255',
            'email' => ['required', 'email', 'string'],
            'phone' => 'required|string|min:2|max:255',
            'secondaryPhone' => 'sometimes|string|min:2|max:255',
        ];

        if ($this->isMethod('post')) {
            $rules['ownerName'] = 'required|string|min:5|max:255';
            $rules['ownerEmail'] = [
                'required',
                'email',
                'string',
                Rule::unique('users', 'email'),
            ];
            $rules['ownerPassword'] = 'required|min:2|max:255|confirmed';
        }

        return $rules;
    }
}
