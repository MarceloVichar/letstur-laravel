<?php

namespace App\Domain\Events\Actions\Event;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class EventData extends Data
{
    public function __construct(
        #[Required, Date]
        public string|Optional $departureDateTime,

        #[Required, Date]
        public string|Optional $arrivalDateTime,

        #[Nullable, IntegerType, Exists('companies', 'id')]
        public int|Optional    $companyId,

        #[Required, IntegerType, Exists('drivers', 'id')]
        public int|Optional    $driverId,

        #[Required, IntegerType, Exists('tours', 'id')]
        public int|Optional    $tourId,

        #[Required, IntegerType, Exists('tour_guides', 'id')]
        public int|Optional    $tourGuideId,

        #[Required, IntegerType, Exists('vehicles', 'id')]
        public int|Optional    $vehicleId
    )
    {
    }
}
