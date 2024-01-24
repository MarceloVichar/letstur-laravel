<?php

namespace Tests\Unit\Domain\Records\Actions\Vehicle;

use App\Domain\Records\Actions\Vehicle\CreateVehicleAction;
use App\Domain\Records\Actions\Vehicle\VehicleData;
use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Records\Enums\VehicleTypeEnum;
use App\Domain\Records\Models\Vehicle;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class CreateVehicleActionTest extends TestCaseUnit
{
    public function test_should_create_vehicle()
    {
        $data = VehicleData::from([
            'licensePlate' => 'abc-1234',
            'type' => VehicleTypeEnum::BUS,
            'model' => 'test',
            'numberOfSeats' => 10,
            'cnhTypeRequired' => CnhTypesEnum::B,
            'ownerName' => 'test',
            'ownerDocument' => '12345678901',
            'ownerPhone' => '1234567890',
            'ownerEmail' => 'test@test.com',
            'companyId' => 1,
        ]);

        $this->mock(Vehicle::class, function (MockInterface $mock) {
            $mock->shouldReceive('create')->once()->andReturn(new Vehicle());
        });

        (new CreateVehicleAction())->execute($data);
    }
}
