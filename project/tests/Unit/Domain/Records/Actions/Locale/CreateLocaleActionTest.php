<?php

namespace Tests\Unit\Domain\Records\Actions\Locale;

use App\Domain\Records\Actions\Locale\CreateLocaleAction;
use App\Domain\Records\Actions\Locale\LocaleData;
use App\Domain\Records\Models\Locale;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class CreateLocaleActionTest extends TestCaseUnit
{
    public function test_should_create_locale()
    {
        $data = LocaleData::from([
            'name' => 'test',
            'zipCode' => '12345678',
            'street' => 'test',
            'number' => '123',
            'complement' => 'test',
            'district' => 'test',
            'city' => 'test',
            'uf' => 'PR',
            'responsibleName' => 'test',
            'responsiblePhone' => '123456789',
            'companyId' => 1,
        ]);

        $this->mock(Locale::class, function (MockInterface $mock) {
            $mock->shouldReceive('create')->once()->andReturn(new Locale());
        });

        (new CreateLocaleAction())->execute($data);
    }
}
