<?php

namespace App\Domain\Dashboard\Actions\Sale;

use App\Domain\Sales\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetSalesInfosAction
{
    public function execute(SaleInfoData $data)
    {
        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
            'sellerId' => 'seller_id',
        ]);

        $startDate = Carbon::parse($dataArray['startDate']);
        $endDate = Carbon::parse($dataArray['endDate']);

        $sales = app(Sale::class)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('company_id', $dataArray['company_id']);

        if (data_get($dataArray, 'seller_id')) {
            $sales->where('seller_id', $dataArray['seller_id']);
        }

        $salesCountAndSumByStatus = $this->getSalesCountAndSumByStatus(clone $sales);
        $salesCountByDate = $this->getSalesCountByDate(clone $sales, $startDate, $endDate, $dataArray['company_id'], $dataArray['seller_id'] ?? null);

        return [
            'salesByDate' => $salesCountByDate,
            'salesByStatus' => $salesCountAndSumByStatus,
        ];
    }

    private function getSalesCountAndSumByStatus($sales)
    {
        return $sales->select('status', DB::raw('count(*) as count'), DB::raw('sum(total_value_cents) as amount'))
            ->groupBy('status')
            ->get()
            ->map(function ($sale) {
                return [
                    'status' => $sale->status,
                    'count' => $sale->count,
                    'amountCents' => $sale->amount,
                ];
            })
            ->toArray();
    }

    private function getSalesCountByDate($sales, $startDate, $endDate, $companyId, $sellerId = null)
    {
        $salesCountByDate = $sales->selectRaw('DATE(created_at) as date')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->when($sellerId, function ($query, $sellerId) {
                return $query->where('seller_id', $sellerId);
            })
            ->get()
            ->pluck('date')
            ->map(function ($date) use ($sellerId, $companyId) {
                return [
                    'date' => $date,
                    'count' => app(Sale::class)
                        ->whereDate('created_at', $date)
                        ->where('company_id', $companyId)
                        ->when($sellerId, function ($query, $sellerId) {
                            return $query->where('seller_id', $sellerId);
                        })
                        ->count(),
                ];
            });
        $datesRange = collect(range(0, $startDate->diffInDays($endDate)))
            ->map(function ($day) use ($startDate) {
                return $startDate->copy()->addDays($day)->toDateString();
            });

        return $datesRange->map(function ($date) use ($salesCountByDate) {
            $count = $salesCountByDate->firstWhere('date', $date)['count'] ?? 0;

            return ['date' => $date, 'count' => $count];
        })
            ->values()
            ->toArray();
    }
}
