<?php

namespace Tests\Feature\Company\Events;

use App\Domain\Events\Models\Event;
use App\Domain\Records\Models\Driver;
use App\Domain\Records\Models\Tour;
use App\Domain\Records\Models\TourGuide;
use App\Domain\Records\Models\Vehicle;
use App\Http\Api\Controllers\Company\Events\EventController;
use Tests\Cases\TestCaseFeature;

class EventTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsCompanyAdmin();
        $this->useActionsFromController(EventController::class);

        $this->driver = Driver::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->tour = Tour::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->vehicle = Vehicle::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->tourGuide = TourGuide::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'totalSeats', 'availableSeats', 'departureDateTime',
            'arrivalDateTime', 'tourGuideId', 'vehicleId', 'tourId',
            'driverId', 'companyId', 'createdAt', 'updatedAt',
        ];
    }

    public function test_should_list_company_events()
    {
        Event::factory()
            ->count(2)
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        Event::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getFormatResourceStructure()],
            ]);
    }

    public function test_should_show_company_event()
    {
        $event = Event::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->getJson($this->controllerAction('show', $event->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }

    public function test_should_not_show_event_from_other_company()
    {
        $event = Event::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $event->id))
            ->assertForbidden();
    }

    public function test_should_create_event_when_valid_data()
    {
        $response = $this->postJson($this->controllerAction('store'), [
            'departureDateTime' => '2030-01-01 00:00:00',
            'arrivalDateTime' => '2030-01-01 03:00:00',
            'tourGuideId' => $this->tourGuide->id,
            'vehicleId' => $this->vehicle->id,
            'tourId' => $this->tour->id,
            'driverId' => $this->driver->id,
        ])
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $event = Event::find($response->offsetGet('id'));

        $this->assertEquals($this->vehicle->number_of_seats, $event->total_seats);
        $this->assertEquals($this->vehicle->number_of_seats, $event->available_seats);
        $this->assertEquals('2030-01-01 00:00:00', $event->departure_date_time);
        $this->assertEquals('2030-01-01 03:00:00', $event->arrival_date_time);
        $this->assertEquals($this->vehicle->id, $event->vehicle_id);
        $this->assertEquals($this->tourGuide->id, $event->tour_guide_id);
        $this->assertEquals($this->tour->id, $event->tour_id);
        $this->assertEquals($this->driver->id, $event->driver_id);
        $this->assertEquals($this->currentUser->company_id, $event->company_id);
    }

    public function test_should_not_create_event_when_invalid_data()
    {
        $this->postJson($this->controllerAction('store'), [])
            ->assertUnprocessable();
    }

    public function test_should_update_event_when_valid_data()
    {
        $event = Event::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $currentAvailableSeats = $event->available_seats;

        $this->putJson($this->controllerAction('update', $event->id), [
            'departureDateTime' => '2030-01-01 00:00:00',
            'arrivalDateTime' => '2030-01-01 03:00:00',
            'tourGuideId' => $this->tourGuide->id,
            'vehicleId' => $this->vehicle->id,
            'tourId' => $this->tour->id,
            'driverId' => $this->driver->id,
        ])
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $event->refresh();
        $this->assertEquals($currentAvailableSeats, $event->available_seats);
        $this->assertEquals('2030-01-01 00:00:00', $event->departure_date_time);
        $this->assertEquals('2030-01-01 03:00:00', $event->arrival_date_time);
        $this->assertEquals($this->vehicle->id, $event->vehicle_id);
        $this->assertEquals($this->tourGuide->id, $event->tour_guide_id);
        $this->assertEquals($this->tour->id, $event->tour_id);
        $this->assertEquals($this->driver->id, $event->driver_id);
        $this->assertEquals($this->currentUser->company_id, $event->company_id);
    }

    public function test_should_not_update_event_when_invalid_data()
    {
        $event = Event::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $event->id), [])
            ->assertUnprocessable();
    }

    public function test_should_not_update_event_from_other_company()
    {
        $event = Event::factory()
            ->create();

        $this->putJson($this->controllerAction('update', $event->id), [
            'departureDateTime' => '2030-01-01 00:00:00',
            'arrivalDateTime' => '2030-01-01 03:00:00',
            'tourGuideId' => $this->tourGuide->id,
            'vehicleId' => $this->vehicle->id,
            'tourId' => $this->tour->id,
            'driverId' => $this->driver->id,
        ])
            ->assertForbidden();
    }

    public function test_should_delete_event()
    {
        $event = Event::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->deleteJson($this->controllerAction('destroy', $event->id))
            ->assertNoContent();

        $this->assertSoftDeleted(Event::class, ['id' => $event->id]);
    }

    public function test_should_not_delete_event_from_other_company()
    {
        $event = Event::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $event->id))
            ->assertForbidden();
    }
}
