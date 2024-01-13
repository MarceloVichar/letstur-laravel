<?php

namespace Tests\Unit\Domain\Sales\Actions\Sale;

use App\Domain\Sales\Actions\Sale\DetachAllEventsAction;
use App\Domain\Sales\Models\Sale;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class DetachAllSaleEventsActionTest extends TestCaseUnit
{
    public function test_should_detach_events_from_sale()
    {
        $modelMock = $this->mock(Sale::class, function (MockInterface $mock) {
            $mock->expects('events->detach')
                ->once()
                ->andReturnSelf();
            $mock->expects('refresh')
                ->once()
                ->andReturnSelf();
        });

        (new DetachAllEventsAction())->execute($modelMock);
    }
}
