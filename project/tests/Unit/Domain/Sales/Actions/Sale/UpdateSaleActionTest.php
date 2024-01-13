<?php

namespace Tests\Unit\Domain\Sales\Actions\Sale;

use App\Domain\Sales\Actions\Sale\SaleInfoData;
use App\Domain\Sales\Actions\Sale\UpdateSaleAction;
use App\Domain\Sales\Models\Sale;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class UpdateSaleActionTest extends TestCaseUnit
{
    public function test_should_create_event()
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

        $model = $this->mock(Sale::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')
                ->once()
                ->withArgs(function ($data) {
                    $this->assertEquals([
                        'customer_name' => 'John Doe',
                        'customer_email' => 'teste',
                        'customer_document' => '12345678901',
                        'customer_phone' => '1234567890',
                        'seller_id' => 1,
                        'company_id' => 1,
                    ], $data);

                    return true;
                })
                ->andReturnSelf();
        });

        $result = (new UpdateSaleAction())->execute($model, $data);

        $this->assertInstanceOf(Sale::class, $result);
    }
}
