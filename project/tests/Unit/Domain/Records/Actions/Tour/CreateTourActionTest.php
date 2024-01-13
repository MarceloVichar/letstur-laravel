<?php

namespace Tests\Unit\Domain\Records\Actions\Tour;

use App\Domain\Records\Actions\Tour\CreateTourAction;
use App\Domain\Records\Actions\Tour\TourData;
use App\Domain\Records\Models\Tour;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class CreateTourActionTest extends TestCaseUnit
{
    public function test_should_create_vehicle()
    {
        $data = TourData::from([
            'name' => 'test',
            'roundTrip' => 200,
            'priceCents' => 100,
            'tourTypeId' => 1,
            'localeId' => 1,
            'companyId' => 1,
        ]);

        $this->mock(Tour::class, function (MockInterface $mock) {
            $mock->shouldReceive('create')->once()->andReturn(new Tour());
        });

        (new CreateTourAction())->execute($data);
    }
}
