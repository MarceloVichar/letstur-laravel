<?php

namespace Tests\Feature\Company\Records;

use App\Domain\Records\Models\Locale;
use App\Domain\Records\Models\Tour;
use App\Domain\Records\Models\TourType;
use App\Http\Api\Controllers\Company\Records\TourController;
use Tests\Cases\TestCaseFeature;

class TourTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsCompanyAdmin();
        $this->useActionsFromController(TourController::class);

        $this->locale = Locale::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->tourType = TourType::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'name', 'roundTrip', 'priceCents',
            'note', 'localeId', 'companyId',
            'tourTypeId', 'createdAt', 'updatedAt',
        ];
    }

    public function test_should_list_company_tours()
    {
        Tour::factory()
            ->count(2)
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        Tour::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getFormatResourceStructure()],
            ]);
    }

    public function test_should_show_company_tour()
    {
        $tour = Tour::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->getJson($this->controllerAction('show', $tour->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }

    public function test_should_not_show_tour_from_other_company()
    {
        $tour = Tour::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $tour->id))
            ->assertForbidden();
    }

    public function test_should_create_tour_when_valid_data()
    {
        $response = $this->postJson($this->controllerAction('store'), [
            'name' => 'Teste',
            'roundTrip' => 121,
            'priceCents' => 10000,
            'note' => 'Teste',
            'localeId' => $this->locale->id,
            'tourTypeId' => $this->tourType->id,
        ])
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $tour = Tour::find($response->offsetGet('id'));

        $this->assertEquals('Teste', $tour->name);
        $this->assertEquals(121, $tour->round_trip);
        $this->assertEquals(10000, $tour->price_cents);
        $this->assertEquals('Teste', $tour->note);
        $this->assertEquals($this->locale->id, $tour->locale_id);
        $this->assertEquals($this->tourType->id, $tour->tour_type_id);
        $this->assertEquals($this->currentUser->company_id, $tour->company_id);
    }

    public function test_should_not_create_tour_when_invalid_data()
    {
        $this->postJson($this->controllerAction('store'), [])
            ->assertUnprocessable();
    }

    public function test_should_update_tour_when_valid_data()
    {
        $tour = Tour::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $tour->id), [
            'name' => 'Teste',
            'roundTrip' => 121,
            'priceCents' => 10000,
            'note' => 'Teste',
            'localeId' => $this->locale->id,
            'tourTypeId' => $this->tourType->id,
        ])
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $tour->refresh();
        $this->assertEquals('Teste', $tour->name);
        $this->assertEquals(121, $tour->round_trip);
        $this->assertEquals(10000, $tour->price_cents);
        $this->assertEquals('Teste', $tour->note);
        $this->assertEquals($this->locale->id, $tour->locale_id);
        $this->assertEquals($this->tourType->id, $tour->tour_type_id);
        $this->assertEquals($this->currentUser->company_id, $tour->company_id);
    }

    public function test_should_not_update_tour_when_invalid_data()
    {
        $tour = Tour::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $tour->id), [])
            ->assertUnprocessable();
    }

    public function test_should_not_update_tour_from_other_company()
    {
        $tour = Tour::factory()
            ->create();

        $this->putJson($this->controllerAction('update', $tour->id), [
            'name' => 'Teste',
            'roundTrip' => 121,
            'priceCents' => 10000,
            'note' => 'Teste',
            'localeId' => $this->locale->id,
            'tourTypeId' => $this->tourType->id,
        ])
            ->assertForbidden();
    }

    public function test_should_delete_tour()
    {
        $tour = Tour::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->deleteJson($this->controllerAction('destroy', $tour->id))
            ->assertNoContent();

        $this->assertSoftDeleted(Tour::class, ['id' => $tour->id]);
    }

    public function test_should_not_delete_tour_from_other_company()
    {
        $tour = Tour::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $tour->id))
            ->assertForbidden();
    }
}
