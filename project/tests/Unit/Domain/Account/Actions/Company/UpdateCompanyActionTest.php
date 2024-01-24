<?php

namespace Tests\Unit\Domain\Account\Actions\Company;

use App\Domain\Account\Actions\Company\CompanyData;
use App\Domain\Account\Actions\Company\UpdateCompanyAction;
use App\Domain\Account\Models\Company;
use Tests\Cases\TestCaseUnit;

class UpdateCompanyActionTest extends TestCaseUnit
{
    public function test_should_update_company()
    {
        $data = CompanyData::from([
            'name' => 'test',
            'tradingName' => 'test',
            'cnpj' => '12345678901234',
            'email' => 'company@test.com',
            'phone' => '1234567890',
            'secondaryPhone' => '1234567890',
        ]);

        $companyMock = $this->createPartialMock(Company::class, ['update']);

        $companyMock->expects($this->once())
            ->method('update')
            ->with([
                'name' => 'test',
                'trading_name' => 'test',
                'cnpj' => '12345678901234',
                'email' => 'company@test.com',
                'phone' => '1234567890',
                'secondary_phone' => '1234567890',
                'ie' => null,
            ])
            ->willReturn(false);

        $result = (new UpdateCompanyAction())->execute($companyMock, $data);

        $this->assertSame($companyMock, $result);
    }
}
