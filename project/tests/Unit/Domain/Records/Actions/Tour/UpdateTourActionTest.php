<?php

namespace Tests\Unit\Domain\Records\Actions\Tour;

use App\Domain\Records\Actions\Tour\TourData;
use App\Domain\Records\Actions\Tour\UpdateTourAction;
use App\Domain\Records\Models\Tour;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class UpdateTourActionTest extends TestCaseUnit
{
    public function test_should_create_tour_type()
    {
        $data = TourData::from([
            'name' => 'test',
            'roundTrip' => 200,
            'priceCents' => 100,
            'tourTypeId' => 1,
            'localeId' => 1,
            'companyId' => 1,
        ]);

        $model = $this->mock(Tour::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')
                ->once()
                ->withArgs(function ($data) {
                    $this->assertEquals([
                        'name' => 'test',
                        'round_trip' => 200,
                        'price_cents' => 100,
                        'tour_type_id' => 1,
                        'locale_id' => 1,
                        'company_id' => 1,
                        'note' => null,
                    ], $data);

                    return true;
                })
                ->andReturnSelf();
        });

        $result = (new UpdateTourAction())->execute($model, $data);

        $this->assertInstanceOf(Tour::class, $result);
    }
}
