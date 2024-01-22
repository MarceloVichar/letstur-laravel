<?php

namespace App\Domain\Sales\Actions\EventSale;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class PassengerData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $name,

        #[Required, StringType]
        public string $document,
    ) {
    }
}
