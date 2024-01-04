<?php

namespace App\Domain\Records\Actions\Tour;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\DateFormat;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class TourData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string|Optional $name,

        #[Required, IntegerType]
        public int|Optional $roundTrip,

        #[Required, IntegerType]
        public int|Optional $priceCents,

        #[Nullable, StringType]
        public string|Optional $note,

        #[Required, StringType, Email]
        public string|Optional $email,

        #[Nullable, IntegerType, Exists('companies', 'id')]
        public int|Optional $companyId,

        #[Required, IntegerType, Exists('locales', 'id')]
        public int|Optional $localeId,

        #[Required, IntegerType, Exists('tour_types', 'id')]
        public int|Optional $tourTypeId,
    ) {
    }
}
