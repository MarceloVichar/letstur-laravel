<?php

namespace Tests\Unit\Domain\Records\Actions\Locale;

use App\Domain\Records\Actions\Locale\DeleteLocaleAction;
use App\Domain\Records\Models\Locale;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class DeleteLocaleActionTest extends TestCaseUnit
{
    public function test_should_delete_locale()
    {
         $model = $this->mock(Locale::class, function (MockInterface $mock) {
            $mock->expects('delete')
                ->once()
                ->andReturnTrue();
        });

        (new DeleteLocaleAction())->execute($model);
    }
}
