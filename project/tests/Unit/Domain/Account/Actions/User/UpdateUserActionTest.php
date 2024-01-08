<?php

namespace Tests\Unit\Domain\Account\Actions\User;

use App\Domain\Account\Actions\User\UpdateUserAction;
use App\Domain\Account\Actions\User\UserData;
use App\Domain\Account\Enums\RoleEnum;
use App\Domain\Account\Models\User;
use Tests\Cases\TestCaseUnit;

class UpdateUserActionTest extends TestCaseUnit
{
    public function test_should_update_user()
    {
        $user = $this->createPartialMock(User::class, ['update']);
        $user->expects($this->once())
            ->method('update')
            ->willReturn(true);

        $data = UserData::from([
            'name' => 'User Test',
            'email' => 'test@gmail.com',
            'password' => '123456',
            'accountId' => 1,
        ]);

        (new UpdateUserAction())->execute($user, $data);
    }

    public function test_should_update_user_without_password()
    {
        $user = $this->createPartialMock(User::class, ['update']);
        $user->expects($this->once())
            ->method('update')
            ->willReturn(true);

        $data = UserData::from([
            'name' => 'User Test',
            'email' => 'test@gmail.com',
            'accountId' => 1,
        ]);

        (new UpdateUserAction())->execute($user, $data);
    }

    public function test_should_update_user_passing_different_role()
    {
        $data = UserData::from([
            'email' => 'test@hotmail.com',
            'password' => '123456',
            'roles' => [
                RoleEnum::COMPANY_OPERATOR,
            ],
            'accountId' => 1,
        ]);

        $userMock = $this->createMock(User::class);
        $userMock->expects($this->once())
            ->method('syncRoles')
            ->with([RoleEnum::COMPANY_OPERATOR]);

        $userMock->expects($this->once())
            ->method('update')
            ->willReturn(true);

        (new UpdateUserAction())->execute($userMock, $data);
    }
}
