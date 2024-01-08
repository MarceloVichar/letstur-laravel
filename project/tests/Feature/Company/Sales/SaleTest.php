<?php

namespace Tests\Feature\Company\Sales;

use App\Domain\Events\Models\Event;
use App\Domain\Sales\Enums\SaleStatusEnum;
use App\Domain\Sales\Jobs\SendSaleVoucherEmailJob;
use App\Domain\Sales\Models\Sale;
use App\Http\Api\Controllers\Company\Sales\ConfirmSaleController;
use App\Http\Api\Controllers\Company\Sales\SaleController;
use Illuminate\Support\Facades\Queue;

class SaleTest extends SaleTestData
{
    public function setUp(): void
    {
        parent::setUp();

        $this->useActionsFromController(SaleController::class);
    }

    private function getFormatResourceStructure()
    {
        return [
            'id', 'customer', 'status', 'voucher', 'totalValueCents', 'sellerId', 'companyId', 'createdAt', 'updatedAt'
        ];
    }

    public function test_should_list_company_sales()
    {
        Sale::factory()
            ->count(2)
            ->create([
                'status' => SaleStatusEnum::PENDING,
                'company_id' => $this->currentUser->company_id,
            ]);

        Sale::factory()
            ->count(2)
            ->create();

        $this->getJson($this->controllerAction('index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['*' => $this->getFormatResourceStructure()],
            ]);
    }

    public function test_should_show_company_sale()
    {
        $sale = Sale::factory()
            ->create([
                'status' => SaleStatusEnum::PENDING,
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->getJson($this->controllerAction('show', $sale->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());
    }

    public function test_should_not_show_sale_from_other_company()
    {
        $sale = Sale::factory()
            ->create();

        $this->getJson($this->controllerAction('show', $sale->id))
            ->assertForbidden();
    }

    public function test_should_create_sale_when_valid_data()
    {
        $response = $this->postJson($this->controllerAction('store'), $this->getRequestData())
            ->assertCreated()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $sale = Sale::find($response->offsetGet('id'));

        $this->checkSaleAsserts($sale);
    }

    public function test_should_not_create_sale_when_invalid_data()
    {
        $this->postJson($this->controllerAction('store'), [])
            ->assertUnprocessable();
    }

    public function test_should_update_sale_when_valid_data()
    {
        $sale = Sale::factory()
            ->create([
                'status' => SaleStatusEnum::PENDING,
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $sale->id), $this->getRequestData())
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $sale->refresh();
        $this->checkSaleAsserts($sale);
    }

    public function test_should_not_update_sale_when_invalid_data()
    {
        $sale = Sale::factory()
            ->create([
                'status' => SaleStatusEnum::PENDING,
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $sale->id), [])
            ->assertUnprocessable();
    }

    public function test_should_not_update_sale_from_other_company()
    {
        $sale = Sale::factory()
            ->create();

        $this->putJson($this->controllerAction('update', $sale->id), $this->getRequestData())
            ->assertForbidden();
    }

    public function test_should_not_update_sale_when_status_is_not_pending()
    {
        $sale = Sale::factory()
            ->create([
                'status' => SaleStatusEnum::CONFIRMED,
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction('update', $sale->id), $this->getRequestData())
            ->assertForbidden();
    }


    public function test_should_delete_sale()
    {
        $sale = Sale::factory()
            ->create([
                'status' => SaleStatusEnum::PENDING,
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->deleteJson($this->controllerAction('destroy', $sale->id))
            ->assertNoContent();

        $this->assertSoftDeleted(Sale::class, ['id' => $sale->id]);
    }

    public function test_should_not_delete_sale_from_other_company()
    {
        $sale = Sale::factory()
            ->create();

        $this->deleteJson($this->controllerAction('destroy', $sale->id))
            ->assertForbidden();
    }

    public function test_should_confirm_sale()
    {
        Queue::fake();

        $this->useActionsFromController(ConfirmSaleController::class);
        $sale = Sale::factory()
            ->create([
                'status' => SaleStatusEnum::PENDING,
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction(null, $sale->id))
            ->assertOk()
            ->assertJsonStructure($this->getFormatResourceStructure());

        $sale->refresh();
        $this->assertEquals(SaleStatusEnum::CONFIRMED, $sale->status);

        Queue::assertPushed(SendSaleVoucherEmailJob::class, function ($job) use ($sale) {
            return $job->sale->id === $sale->id;
        });
    }

    public function test_should_not_confirm_sale_from_other_company()
    {
        $this->useActionsFromController(ConfirmSaleController::class);
        $sale = Sale::factory()
            ->create();

        $this->putJson($this->controllerAction(null, $sale->id))
            ->assertForbidden();
    }

    public function test_should_not_confirm_sale_when_status_is_not_pending()
    {
        $this->useActionsFromController(ConfirmSaleController::class);
        $sale = Sale::factory()
            ->create([
                'status' => SaleStatusEnum::CONFIRMED,
                'company_id' => $this->currentUser->company_id,
            ]);

        $this->putJson($this->controllerAction(null, $sale->id))
            ->assertForbidden();
    }
}
