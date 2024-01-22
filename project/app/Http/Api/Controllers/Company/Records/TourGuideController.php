<?php

namespace App\Http\Api\Controllers\Company\Records;

use App\Domain\Records\Actions\TourGuide\CreateTourGuideAction;
use App\Domain\Records\Actions\TourGuide\DeleteTourGuideAction;
use App\Domain\Records\Actions\TourGuide\UpdateTourGuideAction;
use App\Domain\Records\Actions\TourGuide\TourGuideData;
use App\Domain\Records\Models\TourGuide;
use App\Http\Api\Requests\Company\Records\TourGuideRequest;
use App\Http\Api\Resources\Company\Records\TourGuideResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class TourGuideController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', TourGuide::class);

        $tourGuides = app(TourGuide::class)
            ->where('company_id', current_user()->company_id);

        return pagination($tourGuides)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
            ])
            ->allowedSorts(['name', 'email', 'created_at'])
            ->defaultSort('created_at')
            ->resource(TourGuideResource::class);
    }

    public function show(TourGuide $tourGuide)
    {
        $this->authorize('view', $tourGuide);

        return response()->json(TourGuideResource::make($tourGuide), 200);
    }

    public function store(TourGuideRequest $request)
    {
        $this->authorize('create', TourGuide::class);

        $data = TourGuideData::validateAndCreate([
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ]);

        $tourGuide = app(CreateTourGuideAction::class)
            ->execute($data);

        return response()->json(TourGuideResource::make($tourGuide), 201);
    }

    public function update(TourGuideRequest $request, TourGuide $tourGuide)
    {
        $this->authorize('update', $tourGuide);

        $data = TourGuideData::validateAndCreate([
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ]);

        $tourGuide = app(UpdateTourGuideAction::class)
            ->execute($tourGuide, $data);

        return response()->json(TourGuideResource::make($tourGuide), 200);
    }

    public function destroy(TourGuide $tourGuide)
    {
        $this->authorize('delete', $tourGuide);

        app(DeleteTourGuideAction::class)
            ->execute($tourGuide);

        return response()->noContent();
    }
}
