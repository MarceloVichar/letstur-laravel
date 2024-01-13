<?php

namespace Tests\Feature\Company\Records;

use App\Domain\Records\Models\TourGuide;
use App\Http\Api\Controllers\Company\Records\TourGuideController;
use Tests\Cases\TestCaseFeature;

class TourGuideTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsCompanyAdmin();
        $this->useActionsFromController(TourGuideController::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'name', 'document', 'phone',
            'email', 'companyId', 'createdAt', 'updatedAt',
        ];
    }

    public function test_should_list_company_tour_guides()
    {
        TourGuide::factory()
            ->count(2)
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        TourGuide::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getFormatResourceStructure()],
            ]);
    }

    public function test_should_show_company_tour_guide()
    {
        $tourGuide = TourGuide::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->getJson($this->controllerAction('show', $tourGuide->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }

    public function test_should_not_show_tour_guide_from_other_company()
    {
        $tourGuide = TourGuide::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $tourGuide->id))
            ->assertForbidden();
    }

    public function test_should_create_tour_guide_when_valid_data()
    {
        $response = $this->postJson($this->controllerAction('store'), [
            'name' => 'Teste',
            'email' => 'driver@email.com',
            'document' => '123456789',
            'phone' => '123456789',
        ])
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $tourGuide = TourGuide::find($response->offsetGet('id'));

        $this->assertEquals('Teste', $tourGuide->name);
        $this->assertEquals('driver@email.com', $tourGuide->email);
        $this->assertEquals('123456789', $tourGuide->document);
        $this->assertEquals('123456789', $tourGuide->phone);
        $this->assertEquals($this->currentUser->company_id, $tourGuide->company_id);
    }

    public function test_should_not_create_tour_guide_when_invalid_data()
    {
        $this->postJson($this->controllerAction('store'), [])
            ->assertUnprocessable();
    }

    public function test_should_update_tour_guide_when_valid_data()
    {
        $tourGuide = TourGuide::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $tourGuide->id), [
            'name' => 'Teste',
            'email' => 'driver@email.com',
            'document' => '123456789',
            'phone' => '123456789',
        ])
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $tourGuide->refresh();
        $this->assertEquals('Teste', $tourGuide->name);
        $this->assertEquals('driver@email.com', $tourGuide->email);
        $this->assertEquals('123456789', $tourGuide->document);
        $this->assertEquals('123456789', $tourGuide->phone);
        $this->assertEquals($this->currentUser->company_id, $tourGuide->company_id);
    }

    public function test_should_not_update_tour_guide_when_invalid_data()
    {
        $tourGuide = TourGuide::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $tourGuide->id), [])
            ->assertUnprocessable();
    }

    public function test_should_not_update_tour_guide_from_other_company()
    {
        $tourGuide = TourGuide::factory()
            ->create();

        $this->putJson($this->controllerAction('update', $tourGuide->id), [
            'name' => 'Teste',
            'email' => 'driver@email.com',
            'document' => '123456789',
            'phone' => '123456789',
        ])
            ->assertForbidden();
    }


    public function test_should_delete_tour_guide()
    {
        $tourGuide = TourGuide::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->deleteJson($this->controllerAction('destroy', $tourGuide->id))
            ->assertNoContent();

        $this->assertSoftDeleted(TourGuide::class, ['id' => $tourGuide->id]);
    }

    public function test_should_not_delete_tour_guide_from_other_company()
    {
        $tourGuide = TourGuide::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $tourGuide->id))
            ->assertForbidden();
    }
}
