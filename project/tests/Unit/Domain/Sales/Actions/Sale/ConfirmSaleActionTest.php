<?php

namespace Tests\Unit\Domain\Sales\Actions\Sale;

use App\Domain\Sales\Actions\Sale\ConfirmSaleAction;
use App\Domain\Sales\Enums\SaleStatusEnum;
use App\Domain\Sales\Models\Sale;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class ConfirmSaleActionTest extends TestCaseUnit
{
    public function test_should_confirm_event()
    {
        $model = $this->mock(Sale::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')
                ->once()
                ->withArgs(function ($data) {
                    $this->assertEquals([
                        'status' => SaleStatusEnum::CONFIRMED,
                    ], $data);

                    return true;
                })
                ->andReturnSelf();
        });

        $result = (new ConfirmSaleAction())->execute($model);

        $this->assertInstanceOf(Sale::class, $result);
    }
}
