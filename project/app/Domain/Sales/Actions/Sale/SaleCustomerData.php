<?php

namespace App\Domain\Sales\Actions\Sale;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class SaleCustomerData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string          $name,

        #[Required, StringType]
        public string          $document,

        #[Required, StringType, Email]
        public string          $email,

        #[Nullable, StringType]
        public string|Optional $phone,
    )
    {
    }
}
