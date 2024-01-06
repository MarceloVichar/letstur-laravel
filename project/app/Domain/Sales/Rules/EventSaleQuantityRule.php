<?php

namespace App\Domain\Sales\Rules;

use App\Domain\Events\Models\Event;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EventSaleQuantityRule implements ValidationRule
{
    private $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function message()
    {
        return 'The :attribute must be between 1 and the number of available seats for the event.';
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $event = Event::find($this->eventId);

        if (!$event || $value < 1 || $value > $event->available_seats) {
            $fail($this->message());
        }
    }
}
