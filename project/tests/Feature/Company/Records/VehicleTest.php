<?php

namespace Tests\Feature\Company\Records;

use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Records\Enums\VehicleTypeEnum;
use App\Domain\Records\Models\Vehicle;
use App\Http\Api\Controllers\Company\Records\VehicleController;
use Tests\Cases\TestCaseFeature;

class VehicleTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsCompanyAdmin();
        $this->useActionsFromController(VehicleController::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'licensePlate', 'type', 'model', 'numberOfSeats',
            'cnhTypeRequired', 'ownerName', 'ownerDocument', 'ownerPhone',
            'ownerEmail', 'companyId', 'createdAt', 'updatedAt',
        ];
    }

    public function test_should_list_company_vehicles()
    {
        Vehicle::factory()
            ->count(2)
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        Vehicle::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getFormatResourceStructure()],
            ]);
    }

    public function test_should_show_company_vehicle()
    {
        $vehicle = Vehicle::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->getJson($this->controllerAction('show', $vehicle->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }

    public function test_should_not_show_vehicle_from_other_company()
    {
        $vehicle = Vehicle::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $vehicle->id))
            ->assertForbidden();
    }

    public function test_should_create_vehicle_when_valid_data()
    {
        $response = $this->postJson($this->controllerAction('store'), [
            'licensePlate' => 'ABC1234',
            'type' => VehicleTypeEnum::BUS,
            'model' => 'Teste',
            'numberOfSeats' => 42,
            'cnhTypeRequired' => CnhTypesEnum::D,
            'ownerName' => 'Teste',
            'ownerDocument' => '12345678900',
            'ownerPhone' => '1234567890',
            'ownerEmail' => 'email@email.com',
        ])
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $vehicle = Vehicle::find($response->offsetGet('id'));

        $this->assertEquals('ABC1234', $vehicle->license_plate);
        $this->assertEquals(VehicleTypeEnum::BUS, $vehicle->type);
        $this->assertEquals('Teste', $vehicle->model);
        $this->assertEquals(42, $vehicle->number_of_seats);
        $this->assertEquals(CnhTypesEnum::D, $vehicle->cnh_type_required);
        $this->assertEquals('Teste', $vehicle->owner_name);
        $this->assertEquals('12345678900', $vehicle->owner_document);
        $this->assertEquals('1234567890', $vehicle->owner_phone);
        $this->assertEquals('email@email.com', $vehicle->owner_email);
        $this->assertEquals($this->currentUser->company_id, $vehicle->company_id);
    }

    public function test_should_not_create_vehicle_when_invalid_data()
    {
        $this->postJson($this->controllerAction('store'), [])
            ->assertUnprocessable();
    }

    public function test_should_update_vehicle_when_valid_data()
    {
        $vehicle = Vehicle::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $vehicle->id), [
            'licensePlate' => 'ABC1234',
            'type' => VehicleTypeEnum::BUS,
            'model' => 'Teste',
            'numberOfSeats' => 42,
            'cnhTypeRequired' => CnhTypesEnum::D,
            'ownerName' => 'Teste',
            'ownerDocument' => '12345678954',
            'ownerPhone' => '1234567849',
            'ownerEmail' => 'email@email.com',
        ])
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $vehicle->refresh();
        $this->assertEquals('ABC1234', $vehicle->license_plate);
        $this->assertEquals(VehicleTypeEnum::BUS, $vehicle->type);
        $this->assertEquals('Teste', $vehicle->model);
        $this->assertEquals(42, $vehicle->number_of_seats);
        $this->assertEquals(CnhTypesEnum::D, $vehicle->cnh_type_required);
        $this->assertEquals('Teste', $vehicle->owner_name);
        $this->assertEquals('12345678954', $vehicle->owner_document);
        $this->assertEquals('1234567849', $vehicle->owner_phone);
        $this->assertEquals('email@email.com', $vehicle->owner_email);
        $this->assertEquals($this->currentUser->company_id, $vehicle->company_id);
    }

    public function test_should_not_update_vehicle_when_invalid_data()
    {
        $vehicle = Vehicle::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $vehicle->id), [])
            ->assertUnprocessable();
    }

    public function test_should_not_update_vehicle_from_other_company()
    {
        $vehicle = Vehicle::factory()
            ->create();

        $this->putJson($this->controllerAction('update', $vehicle->id), [
            'licensePlate' => 'ABC1234',
            'type' => VehicleTypeEnum::BUS,
            'model' => 'Teste',
            'numberOfSeats' => 42,
            'cnhTypeRequired' => CnhTypesEnum::D,
            'ownerName' => 'Teste',
            'ownerDocument' => '12345678976',
            'ownerPhone' => '1234567896',
            'ownerEmail' => 'email@email.com',
        ])
            ->assertForbidden();
    }

    public function test_should_delete_vehicle()
    {
        $vehicle = Vehicle::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->deleteJson($this->controllerAction('destroy', $vehicle->id))
            ->assertNoContent();

        $this->assertSoftDeleted(Vehicle::class, ['id' => $vehicle->id]);
    }

    public function test_should_not_delete_vehicle_from_other_company()
    {
        $vehicle = Vehicle::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $vehicle->id))
            ->assertForbidden();
    }
}
