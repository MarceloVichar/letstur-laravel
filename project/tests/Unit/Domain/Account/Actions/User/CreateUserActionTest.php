<?php

namespace Tests\Unit\Domain\Account\Actions\User;

use App\Domain\Account\Actions\User\CreateUserAction;
use App\Domain\Account\Actions\User\UserData;
use App\Domain\Account\Enums\RoleEnum;
use App\Domain\Account\Models\User;
use Tests\Cases\TestCaseUnit;

class CreateUserActionTest extends TestCaseUnit
{
    public function test_should_create_user()
    {
        $data = UserData::from([
            'email' => 'test@hotmail.com',
            'password' => '12345678',
            'roles' => [
                RoleEnum::ADMIN,
            ],
            'accountId' => 1,
        ]);

        $userMock = $this->createMock(User::class);
        $userMock->expects($this->once())
            ->method('assignRole')
            ->with([RoleEnum::ADMIN]);

        $this->mock(User::class, function ($mock) use ($userMock) {
            $mock->shouldReceive('create')->andReturn($userMock);
        });

        (new CreateUserAction())->execute($data);

        $this->assertInstanceOf(User::class, $userMock);
    }
}
