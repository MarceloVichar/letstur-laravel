<?php

namespace Tests\Feature\Company\Records;

use App\Domain\Records\Models\TourType;
use App\Http\Api\Controllers\Company\Records\TourTypeController;
use Tests\Cases\TestCaseFeature;

class TourTypeTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsCompanyAdmin();
        $this->useActionsFromController(TourTypeController::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'name', 'color', 'isExclusive', 'isTransfer',
            'companyId', 'createdAt', 'updatedAt',
        ];
    }

    public function test_should_list_company_tour_types()
    {
        TourType::factory()
            ->count(2)
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        TourType::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getFormatResourceStructure()],
            ]);
    }

    public function test_should_show_company_tour_type()
    {
        $driver = TourType::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->getJson($this->controllerAction('show', $driver->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }

    public function test_should_not_show_tour_type_from_other_company()
    {
        $driver = TourType::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $driver->id))
            ->assertForbidden();
    }

    public function test_should_create_tour_type_when_valid_data()
    {
        $response = $this->postJson($this->controllerAction('store'), [
            'name' => 'Teste',
            'color' => '#000000',
            'isExclusive' => true,
            'isTransfer' => true,
        ])
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $driver = TourType::find($response->offsetGet('id'));

        $this->assertEquals('Teste', $driver->name);
        $this->assertEquals('#000000', $driver->color);
        $this->assertTrue($driver->is_exclusive);
        $this->assertTrue($driver->is_transfer);
        $this->assertEquals($this->currentUser->company_id, $driver->company_id);
    }

    public function test_should_not_create_tour_type_when_invalid_data()
    {
        $this->postJson($this->controllerAction('store'), [])
            ->assertUnprocessable();
    }

    public function test_should_update_tour_type_when_valid_data()
    {
        $driver = TourType::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $driver->id), [
            'name' => 'Teste',
            'color' => '#000000',
            'isExclusive' => true,
            'isTransfer' => true,
        ])
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $driver->refresh();
        $this->assertEquals('Teste', $driver->name);
        $this->assertEquals('#000000', $driver->color);
        $this->assertTrue($driver->is_exclusive);
        $this->assertTrue($driver->is_transfer);
        $this->assertEquals($this->currentUser->company_id, $driver->company_id);
    }

    public function test_should_not_update_tour_type_when_invalid_data()
    {
        $driver = TourType::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $driver->id), [])
            ->assertUnprocessable();
    }

    public function test_should_not_update_tour_type_from_other_company()
    {
        $driver = TourType::factory()
            ->create();

        $this->putJson($this->controllerAction('update', $driver->id), [
            'name' => 'Teste',
            'color' => '#000000',
            'isExclusive' => true,
            'isTransfer' => true,
        ])
            ->assertForbidden();
    }


    public function test_should_delete_tour_type()
    {
        $driver = TourType::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->deleteJson($this->controllerAction('destroy', $driver->id))
            ->assertNoContent();

        $this->assertSoftDeleted(TourType::class, ['id' => $driver->id]);
    }

    public function test_should_not_delete_tour_type_from_other_company()
    {
        $driver = TourType::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $driver->id))
            ->assertForbidden();
    }
}
