<?php

namespace Tests\Feature\Company\Sales;

use App\Domain\Events\Models\Event;
use App\Domain\Records\Models\Vehicle;
use App\Domain\Sales\Models\Sale;
use Tests\Cases\TestCaseFeature;

class SaleTestData extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loginAsCompanyAdmin();

        $this->vehicle = Vehicle::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
                'number_of_seats' => 10,
            ]);

        $this->event = Event::factory()
            ->create([
                'company_id' => $this->currentUser->company_id,
                'vehicle_id' => $this->vehicle->id,
            ]);
    }

    protected function getRequestData()
    {
        return [
            'customer' => [
                'name' => 'John Doe',
                'document' => '12345678901',
                'email' => 'email@teste.com',
                'phone' => '11999999999',
            ],
            'eventSales' => [
                [
                    'eventId' => $this->event->id,
                    'quantity' => 1,
                    'passengers' => [
                        [
                            'name' => 'John Doe',
                            'document' => '12345678901',
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function checkSaleAsserts(Sale $sale): void
    {
        $this->assertEquals(data_get($this->getRequestData(), 'customer.name'), $sale->customer_name);
        $this->assertEquals(data_get($this->getRequestData(), 'customer.email'), $sale->customer_email);
        $this->assertEquals(data_get($this->getRequestData(), 'customer.document'), $sale->customer_document);
        $this->assertEquals(data_get($this->getRequestData(), 'customer.phone'), $sale->customer_phone);
        $this->assertEquals(
            (
                (data_get($this->getRequestData(), 'eventSales.0.quantity') * $this->event->tour->price_cents)
            ), $sale->total_value_cents
        );
        $this->assertEquals(data_get($this->getRequestData(), 'eventSales.0.eventId'), $sale->events->last()->id);
        $this->assertEquals(data_get($this->getRequestData(), 'eventSales.0.quantity'), $sale->events->last()->pivot->quantity);
        $this->assertEquals(
            (data_get($this->getRequestData(), 'eventSales.0.quantity') * $this->event->tour->price_cents),
            $sale->events->last()->pivot->total_value_cents
        );
        $this->assertEquals(data_get($this->getRequestData(), 'eventSales.0.passengers.0.name'), json_decode($sale->events->last()->pivot->passengers)[0]->name);
        $this->assertEquals(data_get($this->getRequestData(), 'eventSales.0.passengers.0.document'), json_decode($sale->events->last()->pivot->passengers)[0]->document);
        $this->assertEquals($this->currentUser->id, $sale->seller_id);
        $this->assertEquals($this->currentUser->company_id, $sale->company_id);
    }
}
