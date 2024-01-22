<?php

namespace Tests\Unit\Domain\Sales\Actions\Sale;

use App\Domain\Sales\Actions\Sale\DeleteSaleAction;
use App\Domain\Sales\Models\Sale;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class DeleteSaleActionTest extends TestCaseUnit
{
    public function test_should_delete_event()
    {
        $model = $this->mock(Sale::class, function (MockInterface $mock) {
            $mock->expects('delete')
                ->once()
                ->andReturnTrue();
        });

        (new DeleteSaleAction())->execute($model);
    }
}
