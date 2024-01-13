<?php

namespace Tests\Unit\Domain\Records\Actions\TourType;

use App\Domain\Records\Actions\TourType\DeleteTourTypeAction;
use App\Domain\Records\Models\TourType;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class DeleteTourTypeActionTest extends TestCaseUnit
{
    public function test_should_delete_tour_type()
    {
         $model = $this->mock(TourType::class, function (MockInterface $mock) {
            $mock->expects('delete')
                ->once()
                ->andReturnTrue();
        });

        (new DeleteTourTypeAction())->execute($model);
    }
}
