<?php

namespace App\Http\Api\Controllers\Company\Records;

use App\Domain\Records\Actions\TourType\CreateTourTypeAction;
use App\Domain\Records\Actions\TourType\DeleteTourTypeAction;
use App\Domain\Records\Actions\TourType\UpdateTourTypeAction;
use App\Domain\Records\Actions\TourType\TourTypeData;
use App\Domain\Records\Models\TourType;
use App\Http\Api\Requests\Company\Records\TourTypeRequest;
use App\Http\Api\Resources\Company\Records\TourTypeResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class TourTypeController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', TourType::class);

        $tourTypes = app(TourType::class)
            ->where('company_id', current_user()->company_id);

        return pagination($tourTypes)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
            ])
            ->allowedSorts(['name', 'email', 'created_at'])
            ->defaultSort('created_at')
            ->resource(TourTypeResource::class);
    }

    public function show(TourType $tourType)
    {
        $this->authorize('view', $tourType);

        return response()->json(TourTypeResource::make($tourType), 200);
    }

    public function store(TourTypeRequest $request)
    {
        $this->authorize('create', TourType::class);

        $data = TourTypeData::validateAndCreate([
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ]);

        $tourType = app(CreateTourTypeAction::class)
            ->execute($data);

        return response()->json(TourTypeResource::make($tourType), 201);
    }

    public function update(TourTypeRequest $request, TourType $tourType)
    {
        $this->authorize('update', $tourType);

        $data = TourTypeData::validateAndCreate($request->validated());

        $tourType = app(UpdateTourTypeAction::class)
            ->execute($tourType, $data);

        return response()->json(TourTypeResource::make($tourType), 200);
    }

    public function destroy(TourType $tourType)
    {
        $this->authorize('delete', $tourType);

        app(DeleteTourTypeAction::class)
            ->execute($tourType);

        return response()->noContent();
    }
}
