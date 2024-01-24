<?php

namespace App\Http\Api\Controllers\Company\Records;

use App\Domain\Records\Actions\Driver\CreateDriverAction;
use App\Domain\Records\Actions\Driver\DeleteDriverAction;
use App\Domain\Records\Actions\Driver\DriverData;
use App\Domain\Records\Actions\Driver\UpdateDriverAction;
use App\Domain\Records\Models\Driver;
use App\Http\Api\Requests\Company\Records\DriverRequest;
use App\Http\Api\Resources\Company\Records\DriverResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class DriverController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', Driver::class);

        $drivers = app(Driver::class)
            ->where('company_id', current_user()->company_id);

        return pagination($drivers)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
                AllowedFilter::partial('cnh_type'),
            ])
            ->allowedSorts(['name', 'email', 'created_at'])
            ->defaultSort('created_at')
            ->resource(DriverResource::class);
    }

    public function show(Driver $driver)
    {
        $this->authorize('view', $driver);

        return response()->json(DriverResource::make($driver), 200);
    }

    public function store(DriverRequest $request)
    {
        $this->authorize('create', Driver::class);

        $data = DriverData::validateAndCreate([
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ]);

        $driver = app(CreateDriverAction::class)
            ->execute($data);

        return response()->json(DriverResource::make($driver), 201);
    }

    public function update(DriverRequest $request, Driver $driver)
    {
        $this->authorize('update', $driver);

        $data = DriverData::validateAndCreate([
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ]);

        $driver = app(UpdateDriverAction::class)
            ->execute($driver, $data);

        return response()->json(DriverResource::make($driver), 200);
    }

    public function destroy(Driver $driver)
    {
        $this->authorize('delete', $driver);

        app(DeleteDriverAction::class)
            ->execute($driver);

        return response()->noContent();
    }
}
