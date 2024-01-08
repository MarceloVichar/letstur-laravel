<?php

namespace Tests\Unit\Domain\Account\Actions\User;

use App\Domain\Account\Actions\User\DeleteUserAction;
use App\Domain\Account\Models\User;
use Tests\Cases\TestCaseUnit;

class DeleteUserActionTest extends TestCaseUnit
{
    public function test_should_delete_user()
    {
        $user = $this->createPartialMock(User::class, ['delete']);
        $user->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        (new DeleteUserAction())->execute($user);
    }
}
