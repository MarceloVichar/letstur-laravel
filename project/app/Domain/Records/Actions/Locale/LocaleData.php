<?php

namespace App\Domain\Records\Actions\Locale;

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

class LocaleData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string|Optional $name,

        #[Required, StringType]
        public string|Optional $zipCode,

        #[Required, StringType]
        public string|Optional $street,

        #[Nullable, StringType]
        public ?string $number,

        #[Nullable, StringType]
        public ?string $complement,

        #[Nullable, StringType]
        public ?string $district,

        #[Required, StringType]
        public string|Optional $city,

        #[Required, StringType]
        public string|Optional $uf,

        #[Required, StringType]
        public string|Optional $responsibleName,

        #[Required, StringType]
        public string|Optional $responsiblePhone,

        #[Nullable, IntegerType, Exists('companies', 'id')]
        public int|Optional    $companyId
    )
    {
    }
}
