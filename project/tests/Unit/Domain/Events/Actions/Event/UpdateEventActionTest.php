<?php

namespace Tests\Unit\Domain\Events\Actions\Event;

use App\Domain\Events\Actions\Event\EventData;
use App\Domain\Events\Actions\Event\UpdateEventAction;
use App\Domain\Events\Models\Event;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class UpdateEventActionTest extends TestCaseUnit
{
    public function test_should_create_event()
    {
        $data = EventData::from([
            'departureDateTime' => '2021-01-01 00:00:00',
            'arrivalDateTime' => '2021-01-01 00:00:00',
            'tourId' => 1,
            'vehicleId' => 1,
            'tourGuideId' => 1,
            'driverId' => 1,
            'companyId' => 1,
        ]);

        $model = $this->mock(Event::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')
                ->once()
                ->withArgs(function ($data) {
                    $this->assertEquals([
                        'departure_date_time' => '2021-01-01 00:00:00',
                        'arrival_date_time' => '2021-01-01 00:00:00',
                        'tour_id' => 1,
                        'vehicle_id' => 1,
                        'tour_guide_id' => 1,
                        'driver_id' => 1,
                        'company_id' => 1,
                    ], $data);

                    return true;
                })
                ->andReturnSelf();
        });

        $result = (new UpdateEventAction())->execute($model, $data);

        $this->assertInstanceOf(Event::class, $result);
    }
}
