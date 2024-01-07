<?php

namespace Tests\Feature\Company\Records;

use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Records\Models\Driver;
use App\Http\Api\Controllers\Company\Records\DriverController;
use Tests\Cases\TestCaseFeature;

class DriverTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsCompanyAdmin();
        $this->useActionsFromController(DriverController::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'name', 'cnh', 'cnhType', 'document',
            'phone', 'dateOfBirth', 'email', 'companyId',
            'createdAt', 'updatedAt',
        ];
    }

    public function test_should_list_company_drivers()
    {
        Driver::factory()
            ->count(2)
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        Driver::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getFormatResourceStructure()],
            ]);
    }

    public function test_should_show_company_driver()
    {
        $driver = Driver::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->getJson($this->controllerAction('show', $driver->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }

    public function test_should_not_show_driver_from_other_company()
    {
        $driver = Driver::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $driver->id))
            ->assertForbidden();
    }

    public function test_should_create_driver_when_valid_data()
    {
        $response = $this->postJson($this->controllerAction('store'), [
            'name' => 'Teste',
            'email' => 'driver@email.com',
            'cnh' => '123456789',
            'cnhType' => CnhTypesEnum::B,
            'document' => '123456789',
            'phone' => '123456789',
            'dateOfBirth' => '1990-01-01',
        ])
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $driver = Driver::find($response->offsetGet('id'));

        $this->assertEquals('Teste', $driver->name);
        $this->assertEquals('driver@email.com', $driver->email);
        $this->assertEquals('123456789', $driver->cnh);
        $this->assertEquals(CnhTypesEnum::B, $driver->cnh_type);
        $this->assertEquals('123456789', $driver->document);
        $this->assertEquals('123456789', $driver->phone);
        $this->assertEquals('1990-01-01', $driver->date_of_birth);
        $this->assertEquals($this->currentUser->company_id, $driver->company_id);
    }

    public function test_should_not_create_driver_when_invalid_data()
    {
        $this->postJson($this->controllerAction('store'), [])
            ->assertUnprocessable();
    }

    public function test_should_update_driver_when_valid_data()
    {
        $driver = Driver::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $driver->id), [
            'name' => 'Teste',
            'email' => 'driver@email.com',
            'cnh' => '123456789',
            'cnhType' => CnhTypesEnum::B,
            'document' => '123456789',
            'phone' => '123456789',
            'dateOfBirth' => '1990-01-01',
        ])
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $driver->refresh();
        $this->assertEquals('Teste', $driver->name);
        $this->assertEquals('driver@email.com', $driver->email);
        $this->assertEquals('123456789', $driver->cnh);
        $this->assertEquals(CnhTypesEnum::B, $driver->cnh_type);
        $this->assertEquals('123456789', $driver->document);
        $this->assertEquals('123456789', $driver->phone);
        $this->assertEquals('1990-01-01', $driver->date_of_birth);
        $this->assertEquals($this->currentUser->company_id, $driver->company_id);
    }

    public function test_should_not_update_driver_when_invalid_data()
    {
        $driver = Driver::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $driver->id), [])
            ->assertUnprocessable();
    }

    public function test_should_not_update_driver_from_other_company()
    {
        $driver = Driver::factory()
            ->create();

        $this->putJson($this->controllerAction('update', $driver->id), [
            'name' => 'Teste',
            'email' => 'driver@email.com',
            'cnh' => '123456789',
            'cnhType' => CnhTypesEnum::B,
            'document' => '123456789',
            'phone' => '123456789',
            'dateOfBirth' => '1990-01-01',
        ])
            ->assertForbidden();
    }


    public function test_should_delete_driver()
    {
        $driver = Driver::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->deleteJson($this->controllerAction('destroy', $driver->id))
            ->assertNoContent();

        $this->assertSoftDeleted(Driver::class, ['id' => $driver->id]);
    }

    public function test_should_not_delete_driver_from_other_company()
    {
        $driver = Driver::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $driver->id))
            ->assertForbidden();
    }
}
