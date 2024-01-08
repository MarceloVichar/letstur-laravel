<?php

namespace Tests\Unit\Domain\Records\Actions\Driver;

use App\Domain\Records\Actions\Driver\DeleteDriverAction;
use App\Domain\Records\Models\Driver;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class DeleteDriverActionTest extends TestCaseUnit
{
    public function test_should_delete_driver()
    {
         $model = $this->mock(Driver::class, function (MockInterface $mock) {
            $mock->expects('delete')
                ->once()
                ->andReturnTrue();
        });

        (new DeleteDriverAction())->execute($model);
    }
}
