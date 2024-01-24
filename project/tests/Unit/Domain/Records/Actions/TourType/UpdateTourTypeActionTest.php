<?php

namespace Tests\Unit\Domain\Records\Actions\TourType;

use App\Domain\Records\Actions\TourType\TourTypeData;
use App\Domain\Records\Actions\TourType\UpdateTourTypeAction;
use App\Domain\Records\Models\TourType;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class UpdateTourTypeActionTest extends TestCaseUnit
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

        $model = $this->mock(TourType::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')
                ->once()
                ->withArgs(function ($data) {
                    $this->assertEquals([
                        'name' => 'test',
                        'color' => '#000000',
                        'is_exclusive' => true,
                        'is_transfer' => true,
                        'company_id' => 1,
                    ], $data);

                    return true;
                })
                ->andReturnSelf();
        });

        $result = (new UpdateTourTypeAction())->execute($model, $data);

        $this->assertInstanceOf(TourType::class, $result);
    }
}
