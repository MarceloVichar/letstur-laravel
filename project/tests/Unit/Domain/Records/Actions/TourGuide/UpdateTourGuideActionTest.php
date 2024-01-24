<?php

namespace Tests\Unit\Domain\Records\Actions\TourGuide;

use App\Domain\Records\Actions\TourGuide\TourGuideData;
use App\Domain\Records\Actions\TourGuide\UpdateTourGuideAction;
use App\Domain\Records\Models\TourGuide;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class UpdateTourGuideActionTest extends TestCaseUnit
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

        $model = $this->mock(TourGuide::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')
                ->once()
                ->withArgs(function ($data) {
                    $this->assertEquals([
                        'name' => 'test',
                        'email' => 'driver@teste.com',
                        'phone' => '1234567890',
                        'document' => '12345678901',
                        'company_id' => 1,
                    ], $data);

                    return true;
                })
                ->andReturnSelf();
        });

        $result = (new UpdateTourGuideAction())->execute($model, $data);

        $this->assertInstanceOf(TourGuide::class, $result);
    }
}
