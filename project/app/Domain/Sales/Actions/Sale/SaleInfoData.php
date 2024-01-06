<?php

namespace App\Domain\Sales\Actions\Sale;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class SaleInfoData extends Data
{
    public function __construct(
        #[Required, DataCollectionOf(SaleCustomerData::class)]
        public SaleCustomerData   $customer,

        #[Nullable, IntegerType, Exists('companies', 'id')]
        public int|Optional   $companyId,

        #[Nullable, IntegerType, Exists('users', 'id')]
        public int|Optional   $sellerId
    )
    {
    }
}
