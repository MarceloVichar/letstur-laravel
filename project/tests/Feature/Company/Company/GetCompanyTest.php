<?php

namespace Tests\Feature\Company\Company;

use App\Http\Api\Controllers\Company\Company\GetUserCompany;
use Tests\Cases\TestCaseFeature;

class GetCompanyTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsCompanyAdmin();

        $this->useActionsFromController(GetUserCompany::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'name', 'tradingName', 'cnpj', 'ie',
            'phone', 'email', 'createdAt', 'updatedAt'
        ];
    }

    public function test_should_show_company()
    {
        $this->getJson($this->controllerAction(null, $this->currentUser->company_id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }
}
