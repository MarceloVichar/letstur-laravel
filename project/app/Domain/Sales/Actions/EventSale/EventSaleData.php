<?php

namespace App\Domain\Sales\Actions\EventSale;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class EventSaleData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int   $quantity,

        #[Required, DataCollectionOf(PassengerData::class)]
        public DataCollection $passengers,

        #[Nullable, IntegerType, Exists('events', 'id')]
        public int   $eventId
    )
    {
    }
}
