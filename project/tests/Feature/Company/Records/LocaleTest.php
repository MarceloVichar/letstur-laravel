<?php

namespace Tests\Feature\Company\Records;

use App\Domain\Records\Models\Locale;
use App\Http\Api\Controllers\Company\Records\LocaleController;
use Tests\Cases\TestCaseFeature;

class LocaleTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsCompanyAdmin();
        $this->useActionsFromController(LocaleController::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'name', 'zipCode', 'street', 'number', 'complement',
            'district', 'city', 'uf', 'responsibleName', 'responsiblePhone',
            'companyId', 'createdAt', 'updatedAt',
        ];
    }

    public function test_should_list_company_locales()
    {
        Locale::factory()
            ->count(2)
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        Locale::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getFormatResourceStructure()],
            ]);
    }

    public function test_should_show_company_locale()
    {
        $locale = Locale::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->getJson($this->controllerAction('show', $locale->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }

    public function test_should_not_show_locale_from_other_company()
    {
        $locale = Locale::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $locale->id))
            ->assertForbidden();
    }

    public function test_should_create_locale_when_valid_data()
    {
        $response = $this->postJson($this->controllerAction('store'), [
            'name' => 'Teste',
            'zipCode' => '12345678',
            'street' => 'Rua Teste',
            'number' => '123',
            'complement' => 'Complemento',
            'district' => 'Bairro',
            'city' => 'Guarapuava',
            'uf' => 'PR',
            'responsibleName' => 'Teste',
            'responsiblePhone' => '123456789',
        ])
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $locale = Locale::find($response->offsetGet('id'));

        $this->assertEquals('Teste', $locale->name);
        $this->assertEquals('12345678', $locale->zip_code);
        $this->assertEquals('Rua Teste', $locale->street);
        $this->assertEquals('123', $locale->number);
        $this->assertEquals('Complemento', $locale->complement);
        $this->assertEquals('Bairro', $locale->district);
        $this->assertEquals('Guarapuava', $locale->city);
        $this->assertEquals('PR', $locale->uf);
        $this->assertEquals('Teste', $locale->responsible_name);
        $this->assertEquals('123456789', $locale->responsible_phone);
        $this->assertEquals($this->currentUser->company_id, $locale->company_id);
    }

    public function test_should_not_create_locale_when_invalid_data()
    {
        $this->postJson($this->controllerAction('store'), [])
            ->assertUnprocessable();
    }

    public function test_should_update_locale_when_valid_data()
    {
        $locale = Locale::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $locale->id), [
            'name' => 'Teste',
            'zipCode' => '12345678',
            'street' => 'Rua Teste',
            'number' => '123',
            'complement' => 'Complemento',
            'district' => 'Bairro',
            'city' => 'Guarapuava',
            'uf' => 'PR',
            'responsibleName' => 'Teste',
            'responsiblePhone' => '123456789',
        ])
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $locale->refresh();
        $this->assertEquals('Teste', $locale->name);
        $this->assertEquals('12345678', $locale->zip_code);
        $this->assertEquals('Rua Teste', $locale->street);
        $this->assertEquals('123', $locale->number);
        $this->assertEquals('Complemento', $locale->complement);
        $this->assertEquals('Bairro', $locale->district);
        $this->assertEquals('Guarapuava', $locale->city);
        $this->assertEquals('PR', $locale->uf);
        $this->assertEquals('Teste', $locale->responsible_name);
        $this->assertEquals('123456789', $locale->responsible_phone);
        $this->assertEquals($this->currentUser->company_id, $locale->company_id);
    }

    public function test_should_not_update_locale_when_invalid_data()
    {
        $locale = Locale::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $locale->id), [])
            ->assertUnprocessable();
    }

    public function test_should_not_update_locale_from_other_company()
    {
        $locale = Locale::factory()
            ->create();

        $this->putJson($this->controllerAction('update', $locale->id), [
            'name' => 'Teste',
            'zipCode' => '12345678',
            'street' => 'Rua Teste',
            'number' => '123',
            'complement' => 'Complemento',
            'district' => 'Bairro',
            'city' => 'Guarapuava',
            'uf' => 'PR',
            'responsibleName' => 'Teste',
            'responsiblePhone' => '123456789',
        ])
            ->assertForbidden();
    }

    public function test_should_delete_locale()
    {
        $locale = Locale::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->deleteJson($this->controllerAction('destroy', $locale->id))
            ->assertNoContent();

        $this->assertSoftDeleted(Locale::class, ['id' => $locale->id]);
    }

    public function test_should_not_delete_locale_from_other_company()
    {
        $locale = Locale::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $locale->id))
            ->assertForbidden();
    }
}
