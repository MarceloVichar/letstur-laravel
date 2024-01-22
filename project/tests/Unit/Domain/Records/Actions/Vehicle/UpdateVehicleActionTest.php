<?php

namespace Tests\Unit\Domain\Records\Actions\Vehicle;

use App\Domain\Records\Actions\Vehicle\UpdateVehicleAction;
use App\Domain\Records\Actions\Vehicle\VehicleData;
use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Records\Enums\VehicleTypeEnum;
use App\Domain\Records\Models\Vehicle;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class UpdateVehicleActionTest extends TestCaseUnit
{
    public function test_should_create_tour_type()
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

        $model = $this->mock(Vehicle::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')
                ->once()
                ->withArgs(function ($data) {
                    $this->assertEquals([
                        'license_plate' => 'abc-1234',
                        'type' => VehicleTypeEnum::BUS,
                        'model' => 'test',
                        'number_of_seats' => 10,
                        'cnh_type_required' => CnhTypesEnum::B,
                        'owner_name' => 'test',
                        'owner_document' => '12345678901',
                        'owner_phone' => '1234567890',
                        'owner_email' => 'test@test.com',
                        'company_id' => 1,
                    ], $data);

                    return true;
                })
                ->andReturnSelf();
        });

        $result = (new UpdateVehicleAction())->execute($model, $data);

        $this->assertInstanceOf(Vehicle::class, $result);
    }
}
