<?php

namespace App\Http\Api\Controllers\Company\Records;

use App\Domain\Records\Actions\Tour\CreateTourAction;
use App\Domain\Records\Actions\Tour\DeleteTourAction;
use App\Domain\Records\Actions\Tour\UpdateTourAction;
use App\Domain\Records\Actions\Tour\TourData;
use App\Domain\Records\Models\Tour;
use App\Http\Api\Requests\Company\Records\TourRequest;
use App\Http\Api\Resources\Company\Records\TourResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class TourController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', Tour::class);

        $tours = app(Tour::class)
            ->where('company_id', current_user()->company_id);

        return pagination($tours)
            ->allowedFilters([
                AllowedFilter::partial('name'),
            ])
            ->with([
                'locale',
                'tourType'
            ])
            ->allowedSorts(['name', 'created_at'])
            ->defaultSort('created_at')
            ->resource(TourResource::class);
    }

    public function show(Tour $tour)
    {
        $this->authorize('view', $tour);

        $tour->loadMissing(['locale', 'tourType']);

        return TourResource::make($tour);
    }

    public function store(TourRequest $request)
    {
        $this->authorize('create', Tour::class);

        $data = TourData::validateAndCreate([
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ]);

        $tour = app(CreateTourAction::class)
            ->execute($data);

        return TourResource::make($tour);
    }

    public function update(TourRequest $request, Tour $tour)
    {
        $this->authorize('update', $tour);

        $data = TourData::validateAndCreate($request->validated());

        $tour = app(UpdateTourAction::class)
            ->execute($tour, $data);

        return TourResource::make($tour);
    }

    public function destroy(Tour $tour)
    {
        $this->authorize('delete', $tour);

        app(DeleteTourAction::class)
            ->execute($tour);

        return response()->noContent();
    }
}
