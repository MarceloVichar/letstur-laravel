<?php

namespace Tests\Feature\Company\Dashboard;

use App\Domain\Events\Models\Event;
use App\Http\Api\Controllers\Company\Dashboard\GetEventsInfosController;
use Tests\Cases\TestCaseFeature;

class GetEventsInfosTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loginAsCompanyAdmin();
        $this->useActionsFromController(GetEventsInfosController::class);
    }

    private function getFormatResourceStructure()
    {
        return ['totalEvents', 'datesWithEvents', 'totalAvailableSeats', 'totalSeats'];
    }

    public function test_should_get_company_events_infos()
    {
        $events = Event::factory()
            ->count(2)
            ->create([
                'company_id' => $this->currentUser->company_id,
                'departure_date_time' => now()->addDays(1)->toDateTime(),
            ]);

        Event::factory()
            ->count(2)
            ->create(['departure_date_time' => now()->addDays(1)->toDateTime()]);

        $queryParams = http_build_query([
            'startDate' => now()->toDateString(),
            'endDate' => now()->addDays(2)->toDateString(),
        ]);

        $response = $this->getJson($this->controllerAction(null) . '?' . $queryParams)
            ->assertOk()
            ->assertJsonPath('totalEvents', 2)
            ->assertJsonCount(3, 'datesWithEvents')
            ->assertJsonStructure($this->getFormatResourceStructure());

        $datesWithEvents = $response->json('datesWithEvents');
        $totalEventsCount = array_reduce($datesWithEvents, function ($carry, $item) {
            return $carry + $item['count'];
        }, 0);

        $this->assertEquals($response->json('totalEvents'), $totalEventsCount);

        $totalSeats = $events->sum('total_seats');

        $totalAvailableSeats = $events->sum('available_seats');

        $this->assertEquals($response->json('totalSeats'), $totalSeats);
        $this->assertEquals($response->json('totalAvailableSeats'), $totalAvailableSeats);
    }
}
