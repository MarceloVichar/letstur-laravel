<?php

namespace App\Domain\Account\Actions\Company;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdateCompanyData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string|Optional $name,

        #[Required, StringType]
        public string|Optional $tradingName,

        #[Required, StringType]
        public string|Optional $cnpj,

        #[Nullable, StringType]
        public string|Optional $ie,

        #[Required, StringType, Email]
        public string|Optional $email,

        #[Required, StringType]
        public string|Optional $phone,

        #[Nullable, StringType]
        public string|Optional $secondaryPhone,
    ) {
    }
}
