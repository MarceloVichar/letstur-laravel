<?php

namespace App\Domain\Dashboard\Actions\Event;

use App\Domain\Events\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetEventsInfosAction
{
    public function execute(EventInfoData $data)
    {
        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
        ]);

        $startDate = Carbon::parse($dataArray['startDate']);
        $endDate = Carbon::parse($dataArray['endDate']);

        $events = app(Event::class)
            ->whereBetween('departure_date_time', [$startDate, $endDate])
            ->where('company_id', $dataArray['company_id']);

        $totalEvents = $this->getEventsCount(clone $events);
        $eventsCountByDate = $this->getEventsCountByDate(clone $events, $startDate, $endDate, $dataArray['company_id']);
        $totalAvailableSeats = $this->getEventsTotalAvailableSeats(clone $events);
        $totalSeats = $this->getEventsTotalSeats(clone $events);

        return [
            'totalEvents' => $totalEvents,
            'datesWithEvents' => $eventsCountByDate,
            'totalAvailableSeats' => $totalAvailableSeats,
            'totalSeats' => $totalSeats,
        ];
    }

    private function getEventsCount($events)
    {
        return $events->count();
    }

    private function getEventsTotalSeats($events)
    {
        return $events->sum('total_seats');
    }

    private function getEventsTotalAvailableSeats($events)
    {
        return $events->sum('available_seats');
    }

    private function getEventsCountByDate($events, $startDate, $endDate, $companyId)
    {
        $eventsCountByDate = $events->selectRaw('DATE(departure_date_time) as date')
            ->groupBy(DB::raw('DATE(departure_date_time)'))
            ->get()
            ->pluck('date')
            ->map(function ($date) use ($companyId) {
                return [
                    'date' => $date,
                    'count' => app(Event::class)
                        ->whereDate('departure_date_time', $date)
                        ->where('company_id', $companyId)
                        ->count(),
                ];
            });

        $datesRange = collect(range(0, $startDate->diffInDays($endDate)))
            ->map(function ($day) use ($startDate) {
                return $startDate->copy()->addDays($day)->toDateString();
            });

        return $datesRange->map(function ($date) use ($eventsCountByDate) {
            $count = $eventsCountByDate->firstWhere('date', $date)['count'] ?? 0;

            return ['date' => $date, 'count' => $count];
        })
            ->values()
            ->toArray();
    }
}
