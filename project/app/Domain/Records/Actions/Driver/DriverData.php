<?php

namespace App\Domain\Records\Actions\Driver;

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

class DriverData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string|Optional $name,

        #[Required, StringType]
        public string|Optional $cnh,

        #[Required, StringType]
        public string|Optional $cnhType,

        #[Nullable, StringType]
        public string|Optional $document,

        #[Required, StringType, Email]
        public string|Optional $email,

        #[Required, StringType]
        public string|Optional $phone,

        #[Nullable, StringType, Date, DateFormat('Y-m-d')]
        public string|Optional $dateOfBirth,

        #[Nullable, IntegerType, Exists('companies', 'id')]
        public int|Optional $companyId
    ) {
    }
}
