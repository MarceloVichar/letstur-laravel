<?php

namespace Tests\Unit\Domain\Records\Actions\TourGuide;

use App\Domain\Records\Actions\TourGuide\CreateTourGuideAction;
use App\Domain\Records\Actions\TourGuide\TourGuideData;
use App\Domain\Records\Models\TourGuide;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class CreateTourGuideActionTest extends TestCaseUnit
{
    public function test_should_create_tour_guide()
    {
        $data = TourGuideData::from([
            'name' => 'test',
            'email' => 'driver@teste.com',
            'phone' => '1234567890',
            'document' => '12345678901',
            'companyId' => 1,
        ]);

        $this->mock(TourGuide::class, function (MockInterface $mock) {
            $mock->shouldReceive('create')->once()->andReturn(new TourGuide());
        });

        (new CreateTourGuideAction())->execute($data);
    }
}
