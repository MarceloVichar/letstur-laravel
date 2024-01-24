<?php

namespace Tests\Unit\Domain\Records\Actions\TourType;

use App\Domain\Records\Actions\TourType\CreateTourTypeAction;
use App\Domain\Records\Actions\TourType\TourTypeData;
use App\Domain\Records\Models\TourType;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class CreateTourTypeActionTest extends TestCaseUnit
{
    public function test_should_create_tour_type()
    {
        $data = TourTypeData::from([
            'name' => 'test',
            'color' => '#000000',
            'isExclusive' => true,
            'isTransfer' => true,
            'companyId' => 1,
        ]);

        $this->mock(TourType::class, function (MockInterface $mock) {
            $mock->shouldReceive('create')->once()->andReturn(new TourType());
        });

        (new CreateTourTypeAction())->execute($data);
    }
}
