<?php

namespace App\Http\Api\Controllers\Company\Sales;

use App\Domain\Sales\Actions\Sale\ConfirmSaleAction;
use App\Domain\Sales\Jobs\SendSaleVoucherEmailJob;
use App\Domain\Sales\Models\Sale;
use App\Http\Api\Resources\Company\Sales\SaleResource;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ConfirmSaleController extends Controller
{
    public function __invoke(Sale $sale): JsonResponse
    {
        $this->authorize('confirm', $sale);

        try {

            $sale = app(ConfirmSaleAction::class)
                ->execute($sale);

            SendSaleVoucherEmailJob::dispatch($sale)->onQueue('emails');
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }

        return response()->json(SaleResource::make($sale), 200);
    }
}
