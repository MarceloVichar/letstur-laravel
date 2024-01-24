<?php

namespace Tests\Unit\Domain\Records\Actions\Locale;

use App\Domain\Records\Actions\Locale\LocaleData;
use App\Domain\Records\Actions\Locale\UpdateLocaleAction;
use App\Domain\Records\Models\Locale;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class UpdateLocaleActionTest extends TestCaseUnit
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

        $model = $this->mock(Locale::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')
                ->once()
                ->andReturnSelf();
        });

        $result = (new UpdateLocaleAction())->execute($model, $data);

        $this->assertInstanceOf(Locale::class, $result);
    }
}
