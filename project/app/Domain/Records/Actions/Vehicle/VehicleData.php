<?php

namespace App\Domain\Records\Actions\Vehicle;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class VehicleData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string|Optional $licensePlate,

        #[Required, StringType]
        public string|Optional $type,

        #[Required, StringType]
        public string|Optional $model,

        #[Required, IntegerType]
        public string|Optional $numberOfSeats,

        #[Required, StringType]
        public string|Optional $cnhTypeRequired,

        #[Required, StringType]
        public string|Optional $ownerName,

        #[Required, StringType]
        public string|Optional $ownerDocument,

        #[Required, StringType, Email]
        public string|Optional $ownerEmail,

        #[Required, StringType]
        public string|Optional $ownerPhone,

        #[Nullable, IntegerType, Exists('companies', 'id')]
        public int|Optional $companyId
    ) {
    }
}
