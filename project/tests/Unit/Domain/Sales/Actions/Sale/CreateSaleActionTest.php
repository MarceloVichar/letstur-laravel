<?php

namespace Tests\Unit\Domain\Sales\Actions\Sale;

use App\Domain\Sales\Actions\Sale\CreateSaleAction;
use App\Domain\Sales\Actions\Sale\SaleInfoData;
use App\Domain\Sales\Models\Sale;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class CreateSaleActionTest extends TestCaseUnit
{
    public function test_should_create_sale()
    {
        $data = SaleInfoData::from([
            'customer' => [
                'name' => 'John Doe',
                'email' => 'teste',
                'document' => '12345678901',
                'phone' => '1234567890',
            ],
            'sellerId' => 1,
            'companyId' => 1,
        ]);

        $this->mock(Sale::class, function (MockInterface $mock) {
            $mock->shouldReceive('create')->once()->andReturn(new Sale());
        });

        (new CreateSaleAction())->execute($data);
    }
}
