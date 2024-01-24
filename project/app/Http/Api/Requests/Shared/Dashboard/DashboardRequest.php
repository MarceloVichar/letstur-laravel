<?php

namespace App\Http\Api\Requests\Shared\Dashboard;

use App\Http\Shared\Requests\FormRequest;
use Carbon\Carbon;

class DashboardRequest extends FormRequest
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
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date', 'after_or_equal:start_date', function ($attribute, $value, $fail) {
                $startDate = Carbon::parse($this->startDate);
                $endDate = Carbon::parse($value);

                if ($startDate->diffInDays($endDate) > 31) {
                    $fail('O intervalo de datas não pode ser maior que 31 dias');
                }
            }],
        ];
    }
}
