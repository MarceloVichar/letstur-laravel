<?php

namespace Tests\Unit\Domain\Events\Actions\Event;

use App\Domain\Events\Actions\Event\DeleteEventAction;
use App\Domain\Events\Models\Event;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class DeleteEventActionTest extends TestCaseUnit
{
    public function test_should_delete_event()
    {
         $model = $this->mock(Event::class, function (MockInterface $mock) {
            $mock->expects('delete')
                ->once()
                ->andReturnTrue();
        });

        (new DeleteEventAction())->execute($model);
    }
}
