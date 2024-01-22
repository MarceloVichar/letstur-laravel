<?php

namespace Tests\Feature\Company\Users;

use App\Domain\Account\Enums\RoleEnum;
use App\Domain\Account\Models\User;
use App\Http\Api\Controllers\Company\UserController;
use Tests\Cases\TestCaseFeature;

class UserTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsCompanyAdmin();
        $this->useActionsFromController(UserController::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'name', 'email', 'createdAt', 'updatedAt',
        ];
    }

    public function test_should_list_company_users()
    {
        User::factory()
            ->count(2)
            ->companyAdmin($this->currentUser->company_id)
            ->create();

        User::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getFormatResourceStructure()],
            ]);
    }

    public function test_should_show_company_user()
    {
        $user = User::factory()
            ->companyOperator($this->currentUser->company_id)
            ->create();

        $this->getJson($this->controllerAction('show', $user->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }

    public function test_should_not_show_user_from_other_company()
    {
        $user = User::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $user->id))
            ->assertForbidden();
    }

    public function test_should_create_user_when_valid_data()
    {
        $response = $this->postJson($this->controllerAction('store'), [
            'name' => 'Teste',
            'email' => 'email@teste.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'roles' => [RoleEnum::COMPANY_ADMIN],
        ])
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $user = User::find($response->offsetGet('id'));

        $this->assertEquals('Teste', $user->name);
        $this->assertEquals('email@teste.com', $user->email);
        $this->assertEquals(RoleEnum::COMPANY_ADMIN, $user->roles->first()->name);
        $this->assertEquals($this->currentUser->company_id, $user->company_id);
    }

    public function test_should_not_create_user_when_invalid_data()
    {
        $this->postJson($this->controllerAction('store'), [])
            ->assertUnprocessable();
    }

    public function test_should_update_user_when_valid_data()
    {
        $user = User::factory()
            ->companyAdmin($this->currentUser->company_id)
            ->create([
                'name' => 'Teste',
                'email' => 'email@teste.com',
            ]);

        $this->putJson($this->controllerAction('update', $user->id), [
            'email' => 'emailnovo@teste.com',
            'name' => 'Teste novo',
        ])
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $user->refresh();
        $this->assertEquals('Teste novo', $user->name);
        $this->assertEquals('emailnovo@teste.com', $user->email);
        $this->assertEquals($this->currentUser->company_id, $user->company_id);
    }

    //nao deve atualizar usuario de outra empresa
    public function test_should_not_update_user_from_other_company()
    {
        $user = User::factory()
            ->create([
                'name' => 'Teste',
                'email' => '',
            ]);

        $this->putJson($this->controllerAction('update', $user->id), [
            'email' => 'emailnovo@teste.com',
            'name' => 'Teste novo',
        ])
            ->assertForbidden();
    }

    public function test_should_delete_user()
    {
        $user = User::factory()
            ->companyAdmin($this->currentUser->company_id)
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $user->id))
            ->assertNoContent();

        $this->assertSoftDeleted(User::class, ['id' => $user->id]);
    }

    public function test_should_not_delete_user_from_other_company()
    {
        $user = User::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $user->id))
            ->assertForbidden();
    }
}
