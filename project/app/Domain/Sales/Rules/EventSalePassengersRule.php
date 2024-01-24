<?php

namespace App\Domain\Sales\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EventSalePassengersRule implements ValidationRule
{
    private $quantity;

    public function __construct($quantity)
    {
        $this->quantity = $quantity;
    }

    public function message()
    {
        return 'The number of passengers must be equal to the quantity.';
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (count($value) != $this->quantity) {
            $fail($this->message());
        }
    }
}
