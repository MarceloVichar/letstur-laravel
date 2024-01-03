<?php

namespace App\Http\Api\Controllers\Company\Records;

use App\Domain\Records\Actions\Vehicle\CreateVehicleAction;
use App\Domain\Records\Actions\Vehicle\DeleteVehicleAction;
use App\Domain\Records\Actions\Vehicle\UpdateVehicleAction;
use App\Domain\Records\Actions\Vehicle\VehicleData;
use App\Domain\Records\Models\Vehicle;
use App\Http\Api\Requests\Company\Records\VehicleRequest;
use App\Http\Api\Resources\Company\Records\VehicleResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class VehicleController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', Vehicle::class);

        $vehicles = app(Vehicle::class)
            ->where('company_id', current_user()->company_id);

        return pagination($vehicles)
            ->allowedFilters([
                AllowedFilter::partial('model'),
                AllowedFilter::partial('owner_document'),
                AllowedFilter::partial('cnh_type_required'),
            ])
            ->allowedSorts(['created_at'])
            ->defaultSort('created_at')
            ->resource(VehicleResource::class);
    }

    public function show(Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        return VehicleResource::make($vehicle);
    }

    public function store(VehicleRequest $request)
    {
        $this->authorize('create', Vehicle::class);

        $data = VehicleData::validateAndCreate([
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ]);

        $vehicle = app(CreateVehicleAction::class)
            ->execute($data);

        return VehicleResource::make($vehicle);
    }

    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);

        $data = VehicleData::validateAndCreate($request->validated());

        $vehicle = app(UpdateVehicleAction::class)
            ->execute($vehicle, $data);

        return VehicleResource::make($vehicle);
    }

    public function destroy(Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);

        app(DeleteVehicleAction::class)
            ->execute($vehicle);

        return response()->noContent();
    }
}
