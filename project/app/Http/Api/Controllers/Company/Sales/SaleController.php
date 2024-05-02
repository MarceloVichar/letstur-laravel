<?php

namespace App\Http\Api\Controllers\Company\Sales;

use App\Domain\Account\Enums\RoleEnum;
use App\Domain\Sales\Actions\Sale\SaleData;
use App\Domain\Sales\Models\Sale;
use App\Domain\Sales\Strategies\Sale\CreateSaleStrategy;
use App\Domain\Sales\Strategies\Sale\DeleteSaleStrategy;
use App\Domain\Sales\Strategies\Sale\UpdateSaleStrategy;
use App\Domain\Shared\Filters\EndDateFilter;
use App\Domain\Shared\Filters\StartDateFilter;
use App\Http\Api\Requests\Company\Sales\SaleRequest;
use App\Http\Api\Resources\Company\Sales\SaleResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class SaleController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', Sale::class);

        $sales = app(Sale::class)
            ->where('company_id', current_user()->company_id);

        if (current_user()->hasRole(RoleEnum::COMPANY_OPERATOR)) {
            $sales = $sales->where('seller_id', current_user()->id);
        }

        return pagination($sales)
            ->allowedFilters([
                AllowedFilter::partial('customer', 'customer_name'),
                AllowedFilter::custom('start_date', new StartDateFilter()),
                AllowedFilter::custom('end_date', new EndDateFilter()),
                AllowedFilter::exact('status'),
            ])
            ->with(['seller'])
            ->allowedSorts(['created_at', 'updated_at'])
            ->defaultSort('-updated_at')
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

        return response()->json(SaleResource::make($sale), 200);
    }

    public function store(SaleRequest $request)
    {
        $this->authorize('create', Sale::class);

        $data = SaleData::validateAndCreate([
            'companyId' => current_user()->company_id,
            'sellerId' => current_user()->id,
            ...$request->validated(),
        ]);

        $sale = app(CreateSaleStrategy::class)
            ->execute($data);

        return response()->json(SaleResource::make($sale), 201);
    }

    public function update(SaleRequest $request, Sale $sale)
    {
        $this->authorize('update', $sale);

        $data = SaleData::validateAndCreate([
            'companyId' => current_user()->company_id,
            'sellerId' => current_user()->id,
            ...$request->validated(),
        ]);

        $sale = app(UpdateSaleStrategy::class)
            ->execute($sale, $data);

        return response()->json(SaleResource::make($sale), 200);
    }

    public function destroy(Sale $sale)
    {
        $this->authorize('delete', $sale);

        app(DeleteSaleStrategy::class)
            ->execute($sale);

        return response()->noContent();
    }
}
