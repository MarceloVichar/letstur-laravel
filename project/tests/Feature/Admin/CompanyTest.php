<?php

namespace Tests\Feature\Admin;

use App\Domain\Account\Enums\RoleEnum;
use App\Domain\Account\Models\Company;
use App\Domain\Account\Models\User;
use App\Http\Api\Controllers\Admin\CompanyController;
use Tests\Cases\TestCaseFeature;

class CompanyTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsAdmin();

        $this->useActionsFromController(CompanyController::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'name', 'tradingName', 'cnpj', 'ie',
            'phone', 'email', 'createdAt', 'updatedAt'
        ];
    }

    public function test_should_list_companies()
    {
        Company::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getFormatResourceStructure()],
            ]);
    }

    public function test_should_show_company()
    {
        $company = Company::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $company->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }

    public function test_should_create_company_and_owner_user_when_valid_data()
    {
        $ownerEmail = 'email@owner.com';

        $response = $this->postJson($this->controllerAction('store'), [
            'name' => 'Teste',
            'tradingName' => 'trading',
            'cnpj' => '12345678901234',
            'ie' => '12345678901234',
            'phone' => '12345678901',
            'email' => 'teste@email.com',
            'secondaryPhone' => '12345678901',
            'ownerName' => 'user name',
            'ownerEmail' => $ownerEmail,
            'ownerPassword' => '12345678',
            'ownerPassword_confirmation' => '12345678',
        ])
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $company = Company::find($response->offsetGet('id'));

        $this->assertEquals('Teste', $company->name);
        $this->assertEquals('trading', $company->trading_name);
        $this->assertEquals('12345678901234', $company->cnpj);
        $this->assertEquals('12345678901234', $company->ie);
        $this->assertEquals('12345678901', $company->phone);
        $this->assertEquals('12345678901', $company->secondary_phone);
        $this->assertEquals('teste@email.com', $company->email);

        $owner = User::where('email', $ownerEmail)->first();
        $this->assertNotNull($owner);
        $this->assertEquals($company->id, $owner->company_id);
        $this->assertEquals(RoleEnum::COMPANY_ADMIN, $owner->roles->first()->name);
    }

    public function test_should_not_create_company_when_invalid_data()
    {
        $this->postJson($this->controllerAction('store'), [])
            ->assertUnprocessable();
    }

    public function test_should_update_company_when_valid_data()
    {
        $company = Company::factory()
            ->create([
                'name' => 'Teste',
                'trading_name' => 'trading',
                'cnpj' => '12345678901234',
                'ie' => '12345678901234',
                'phone' => '12345678901',
                'email' => 'teste@email.com',
                'secondary_phone' => '12345678901'
            ]);

        $this->putJson($this->controllerAction('update', $company->id), [
            'name' => 'Teste new',
            'tradingName' => 'trading new',
            'cnpj' => '12345678901235',
            'ie' => '12345678901235',
            'phone' => '12345678902',
            'email' => 'testenew@email.com',
            'secondaryPhone' => '12345678902'
        ])
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $company->refresh();

        $this->assertEquals('Teste new', $company->name);
        $this->assertEquals('trading new', $company->trading_name);
        $this->assertEquals('12345678901235', $company->cnpj);
        $this->assertEquals('12345678901235', $company->ie);
        $this->assertEquals('12345678902', $company->phone);
        $this->assertEquals('12345678902', $company->secondary_phone);
        $this->assertEquals('testenew@email.com', $company->email);
    }

    public function test_should_delete_company()
    {
        $company = Company::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $company->id))
            ->assertNoContent();

        $this->assertSoftDeleted(Company::class, ['id' => $company->id]);
    }
}
