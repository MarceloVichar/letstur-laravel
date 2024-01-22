<?php

namespace App\Domain\Sales\Actions\Sale;

use App\Domain\Sales\Actions\EventSale\EventSaleData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class SaleData extends Data
{
    public function __construct(
        #[Required, DataCollectionOf(SaleCustomerData::class)]
        public SaleCustomerData $customer,

        #[Required, IntegerType, Exists('companies', 'id')]
        public int $companyId,

        #[Required, IntegerType, Exists('users', 'id')]
        public int $sellerId,

        #[Required, DataCollectionOf(EventSaleData::class)]
        public DataCollection $eventSales,
    ) {
    }
}
