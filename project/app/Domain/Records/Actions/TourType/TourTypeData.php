<?php

namespace App\Domain\Records\Actions\TourType;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class TourTypeData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string|Optional $name,

        #[Nullable, StringType]
        public string|Optional $color,

        #[Nullable, BooleanType]
        public bool|Optional $isExclusive,

        #[Nullable, BooleanType]
        public bool|Optional $isTransfer,

        #[Nullable, IntegerType, Exists('companies', 'id')]
        public int|Optional $companyId
    ) {
    }
}
