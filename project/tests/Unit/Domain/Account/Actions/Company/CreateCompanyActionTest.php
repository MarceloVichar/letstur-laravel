<?php

namespace Tests\Unit\Domain\Account\Actions\Company;

use App\Domain\Account\Actions\Company\CompanyData;
use App\Domain\Account\Actions\Company\CreateCompanyAction;
use App\Domain\Account\Models\Company;
use Tests\Cases\TestCaseUnit;

class CreateCompanyActionTest extends TestCaseUnit
{
    public function test_should_create_company()
    {
        $data = CompanyData::from([
            'name' => 'test',
            'tradingName' => 'test',
            'cnpj' => '12345678901234',
            'email' => 'company@test.com',
            'phone' => '1234567890',
            'secondaryPhone' => '1234567890',
        ]);

        $companyMock = $this->createMock(Company::class);

        $this->mock(Company::class)
            ->expects('create')
            ->with([
                'name' => 'test',
                'trading_name' => 'test',
                'cnpj' => '12345678901234',
                'email' => 'company@test.com',
                'phone' => '1234567890',
                'secondary_phone' => '1234567890',
            ])
            ->andReturn($companyMock);

        (new CreateCompanyAction())->execute($data);

        $this->assertInstanceOf(Company::class, $companyMock);
    }
}
