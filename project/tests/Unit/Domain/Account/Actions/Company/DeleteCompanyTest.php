<?php

namespace Tests\Unit\Domain\Account\Actions\Company;

use App\Domain\Account\Actions\Company\DeleteCompanyAction;
use App\Domain\Account\Models\Company;
use Tests\Cases\TestCaseUnit;

class DeleteCompanyTest extends TestCaseUnit
{
    public function test_should_delete_user()
    {
        $company = $this->createPartialMock(Company::class, ['delete']);
        $company->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        (new DeleteCompanyAction())->execute($company);
    }
}
