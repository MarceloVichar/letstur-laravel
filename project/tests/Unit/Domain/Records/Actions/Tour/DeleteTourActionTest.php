<?php

namespace Tests\Unit\Domain\Records\Actions\Tour;

use App\Domain\Records\Actions\Tour\DeleteTourAction;
use App\Domain\Records\Models\Tour;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class DeleteTourActionTest extends TestCaseUnit
{
    public function test_should_delete_vehicle()
    {
         $model = $this->mock(Tour::class, function (MockInterface $mock) {
            $mock->expects('delete')
                ->once()
                ->andReturnTrue();
        });

        (new DeleteTourAction())->execute($model);
    }
}
