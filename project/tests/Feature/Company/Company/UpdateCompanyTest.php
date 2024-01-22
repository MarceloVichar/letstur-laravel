<?php

namespace Tests\Feature\Company\Company;

use App\Http\Api\Controllers\Company\Company\UpdateUserCompany;
use Tests\Cases\TestCaseFeature;

class UpdateCompanyTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsCompanyAdmin();

        $this->useActionsFromController(UpdateUserCompany::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'name', 'tradingName', 'cnpj', 'ie',
            'phone', 'email', 'createdAt', 'updatedAt',
        ];
    }

    public function test_should_update_company_when_valid_data()
    {
        $company = $this->currentUser->company()->first();

        $this->putJson($this->controllerAction(null, $company->id), [
            'name' => 'Teste new',
            'tradingName' => 'trading new',
            'cnpj' => '12345678901235',
            'ie' => '12345678901235',
            'phone' => '12345678902',
            'email' => 'testenew@email.com',
            'secondaryPhone' => '12345678902',
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
        $this->assertEquals($this->currentUser->company_id, $company->id);
    }

    public function test_should_not_update_company_when_invalid_data()
    {
        $company = $this->currentUser->company()->first();

        $this->putJson($this->controllerAction(null, $company->id), [])
            ->assertUnprocessable();
    }
}
