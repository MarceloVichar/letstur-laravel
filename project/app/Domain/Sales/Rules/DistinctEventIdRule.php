<?php

namespace App\Domain\Sales\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DistinctEventIdRule implements ValidationRule
{
    private $eventSales;

    public function __construct($eventSales)
    {
        $this->eventSales = $eventSales;
    }

    public function message(): string
    {
        return 'The eventSales array must not contain duplicate eventId.';
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $eventIds = array_column($this->eventSales, 'eventId');
        if (count($eventIds) !== count(array_unique($eventIds))) {
            $fail($this->message());
        };
    }
}
