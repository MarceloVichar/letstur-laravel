<?php

namespace Tests\Unit\Domain\Records\Actions\Driver;

use App\Domain\Records\Actions\Driver\DriverData;
use App\Domain\Records\Actions\Driver\UpdateDriverAction;
use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Records\Models\Driver;
use Mockery\MockInterface;
use Tests\Cases\TestCaseUnit;

class UpdateDriverActionTest extends TestCaseUnit
{
    public function test_should_create_driver()
    {
        $data = DriverData::from([
            'name' => 'test',
            'cnh' => '12345678901',
            'cnhType' => CnhTypesEnum::B,
            'email' => 'driver@teste.com',
            'phone' => '1234567890',
            'dateOfBirth' => '1990-01-01',
            'document' => '12345678901',
            'companyId' => 1,
        ]);

        $model = $this->mock(Driver::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')
                ->once()
                ->andReturnSelf();
        });

        $result = (new UpdateDriverAction())->execute($model, $data);

        $this->assertInstanceOf(Driver::class, $result);
    }
}
