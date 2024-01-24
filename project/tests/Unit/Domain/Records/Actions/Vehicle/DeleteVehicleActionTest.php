<?php

namespace Tests\Unit\Domain\Records\Actions\Vehicle;

use App\Domain\Records\Actions\Vehicle\DeleteVehicleAction;
use App\Domain\Records\Models\Vehicle;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class DeleteVehicleActionTest extends TestCaseUnit
{
    public function test_should_delete_vehicle()
    {
        $model = $this->mock(Vehicle::class, function (MockInterface $mock) {
            $mock->expects('delete')
                ->once()
                ->andReturnTrue();
        });

        (new DeleteVehicleAction())->execute($model);
    }
}
