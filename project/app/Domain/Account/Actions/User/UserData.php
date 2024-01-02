<?php

namespace App\Domain\Account\Actions\User;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UserData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string|Optional $name,

        #[Required, StringType, Email]
        public string|Optional $email,

        #[Required, StringType]
        public string|Optional $password,

        #[Required, ArrayType]
        public array|Optional $roles,
    ) {
    }
}
