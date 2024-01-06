<?php

namespace App\Domain\Sales\Rules;

use App\Domain\Events\Models\Event;
use App\Domain\Sales\Models\Sale;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EventSaleQuantityUpdateRule implements ValidationRule
{
    private $eventId;
    private $sale;

    public function __construct($eventId, Sale $sale)
    {
        $this->eventId = $eventId;
        $this->sale = $sale;
    }

    public function message()
    {
        return 'The :attribute must be between 1 and the number of available seats for the event.';
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $event = Event::find($this->eventId);

        $currentQuantity = $this->sale->events()->where('event_id', $this->eventId)->first()->pivot->quantity ?? 0;

        if ($value < 1 || $value > ($event->available_seats + $currentQuantity)) {
            $fail($this->message());
        }
    }
}
