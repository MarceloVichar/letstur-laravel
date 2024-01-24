<?php

namespace App\Http\Api\Controllers\Company\Dashboard;

use App\Domain\Dashboard\Actions\Event\EventInfoData;
use App\Domain\Dashboard\Actions\Event\GetEventsInfosAction;
use App\Domain\Events\Models\Event;
use App\Http\Api\Requests\Shared\Dashboard\DashboardRequest;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GetEventsInfosController extends Controller
{
    public function __invoke(DashboardRequest $request): JsonResponse
    {
        $this->authorize('viewAny', Event::class);

        $data = EventInfoData::validateAndCreate([
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ]);

        $eventsInfos = app(GetEventsInfosAction::class)
            ->execute($data);

        return response()->json($eventsInfos, 200);
    }
}
