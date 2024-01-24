<?php

namespace App\Domain\Dashboard\Actions\Event;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class EventInfoData extends Data
{
    public function __construct(
        #[Required, Date, StringType]
        public string $startDate,

        #[Required, Date, StringType]
        public string $endDate,

        #[Nullable, IntegerType, Exists('companies', 'id')]
        public int|Optional $companyId,
    ) {
    }
}
