<?php

namespace Tests\Unit\Domain\Records\Actions\TourGuide;

use App\Domain\Records\Actions\TourGuide\DeleteTourGuideAction;
use App\Domain\Records\Models\TourGuide;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class DeleteTourGuideActionTest extends TestCaseUnit
{
    public function test_should_delete_tour_guide()
    {
         $model = $this->mock(TourGuide::class, function (MockInterface $mock) {
            $mock->expects('delete')
                ->once()
                ->andReturnTrue();
        });

        (new DeleteTourGuideAction())->execute($model);
    }
}
