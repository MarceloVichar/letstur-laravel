<?php

namespace App\Http\Api\Controllers\Company\Events;

use App\Domain\Events\Actions\Event\CreateEventAction;
use App\Domain\Events\Actions\Event\DeleteEventAction;
use App\Domain\Events\Actions\Event\EventData;
use App\Domain\Events\Actions\Event\UpdateEventAction;
use App\Domain\Events\Models\Event;
use App\Domain\Shared\Filters\EndDateFilter;
use App\Domain\Shared\Filters\StartDateFilter;
use App\Http\Api\Requests\Company\Events\EventRequest;
use App\Http\Api\Resources\Company\Events\EventResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class EventController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', Event::class);

        $events = app(Event::class)
            ->where('company_id', current_user()->company_id);

        return pagination($events)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('tour', 'tour.name'),
                AllowedFilter::partial('driver', 'driver.name'),
                AllowedFilter::partial('vehicle', 'vehicle.model'),
                AllowedFilter::partial('tour_guide', 'tourGuide.name'),
                AllowedFilter::custom('departure_start_date', new StartDateFilter('departure_date_time')),
                AllowedFilter::custom('departure_end_date', new EndDateFilter('departure_date_time')),
            ])
            ->with([
                'driver',
                'vehicle',
                'tourGuide',
                'tour',
            ])
            ->allowedSorts(['created_at'])
            ->defaultSort('created_at')
            ->resource(EventResource::class);
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);

        $event->loadMissing([
            'driver',
            'vehicle',
            'tourGuide',
            'tour',
        ]);

        return response()->json(EventResource::make($event), 200);
    }

    public function store(EventRequest $request)
    {
        $this->authorize('create', Event::class);

        $data = EventData::validateAndCreate([
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ]);

        $event = app(CreateEventAction::class)
            ->execute($data);

        return response()->json(EventResource::make($event), 201);
    }

    public function update(EventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        $data = EventData::validateAndCreate([
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ]);

        $event = app(UpdateEventAction::class)
            ->execute($event, $data);

        return response()->json(EventResource::make($event), 200);
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        app(DeleteEventAction::class)
            ->execute($event);

        return response()->noContent();
    }
}
