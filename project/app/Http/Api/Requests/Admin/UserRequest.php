<?php

namespace App\Http\Api\Requests\Admin;

use App\Domain\Account\Enums\RoleEnum;
use App\Domain\Shared\Rules\ValidEnumValue;
use App\Http\Shared\Requests\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'string',
                Rule::unique('users', 'email'),
            ],
            'password' => 'required|min:8|max:255|confirmed',
            'roles' => [
                'required',
                'array',
            ],
            'roles.*' => [
                'required',
                'string',
                (new ValidEnumValue(RoleEnum::class))->strict(),
            ],
            'companyId' => [
                'integer',
                'exists:companies,id',
                in_array(RoleEnum::ADMIN, $this->input('roles', []), true) ? 'nullable' : 'required',
            ],
        ];

        if ($this->isMethod('PUT')) {
            $rules['email'] = [
                'required',
                'string',
                Rule::unique('users', 'email')
                    ->ignore($this->route('user')->id),
            ];
            $rules['password'] = 'nullable|string|confirmed';
        }

        return $rules;
    }
}
