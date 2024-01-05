<?php

namespace App\Http\Api\Controllers\Company\Sales;

use App\Domain\Sales\Actions\Sale\DeleteSaleAction;
use App\Domain\Sales\Actions\Sale\UpdateSaleAction;
use App\Domain\Sales\Actions\Sale\SaleData;
use App\Domain\Sales\Models\Sale;
use App\Domain\Sales\Strategies\Sale\CreateSaleStrategy;
use App\Http\Api\Requests\Company\Sales\SaleRequest;
use App\Http\Api\Resources\Company\Sales\SaleResource;
use App\Http\Shared\Controllers\ResourceController;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

class SaleController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', Sale::class);

        $sales = app(Sale::class)
            ->where('company_id', current_user()->company_id);

        return pagination($sales)
            ->allowedFilters([
                AllowedFilter::partial('customer_name'),
                AllowedFilter::partial('customer_email'),
                AllowedFilter::partial('customer_document'),
            ])
            ->with(['company', 'seller', 'events'])
            ->allowedSorts(['created_at'])
            ->defaultSort('created_at')
            ->resource(SaleResource::class);
    }

    public function show(Sale $sale)
    {
        $this->authorize('view', $sale);

        $sale->loadMissing([
            'company',
            'seller',
            'events',
        ]);

        return SaleResource::make($sale);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Sale::class);

        $data = SaleData::validateAndCreate([
            'companyId' => current_user()->company_id,
            'sellerId' => current_user()->id,
            ...$request->all(),
        ]);

        $sale = app(CreateSaleStrategy::class)
            ->execute($data);

        return response()->json($sale);
    }

    public function update(SaleRequest $request, Sale $sale)
    {
        $this->authorize('update', $sale);

        $data = SaleData::validateAndCreate($request->validated());

        $sale = app(UpdateSaleAction::class)
            ->execute($sale, $data);

        return SaleResource::make($sale);
    }

    public function destroy(Sale $sale)
    {
        $this->authorize('delete', $sale);

        app(DeleteSaleAction::class)
            ->execute($sale);

        return response()->noContent();
    }
}
