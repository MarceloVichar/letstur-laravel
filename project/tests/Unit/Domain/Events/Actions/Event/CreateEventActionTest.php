<?php

namespace Tests\Unit\Domain\Events\Actions\Event;

use App\Domain\Events\Actions\Event\CreateEventAction;
use App\Domain\Events\Actions\Event\EventData;
use App\Domain\Events\Models\Event;
use App\Domain\Records\Models\Vehicle;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class CreateEventActionTest extends TestCaseUnit
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

        $this->mock(Vehicle::class, function (MockInterface $mock) {
            $mock->shouldReceive('find')->with(1)->once()->andReturn(['number_of_seats' => 10]);
        });

        $this->mock(Event::class, function (MockInterface $mock) {
            $mock->shouldReceive('create')->once()->andReturn(new Event());
        });

        (new CreateEventAction())->execute($data);
    }
}
