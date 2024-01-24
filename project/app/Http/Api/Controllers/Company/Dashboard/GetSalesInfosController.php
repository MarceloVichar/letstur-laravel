<?php

namespace App\Http\Api\Controllers\Company\Dashboard;

use App\Domain\Account\Enums\RoleEnum;
use App\Domain\Dashboard\Actions\Sale\GetSalesInfosAction;
use App\Domain\Dashboard\Actions\Sale\SaleInfoData;
use App\Domain\Sales\Models\Sale;
use App\Http\Api\Requests\Shared\Dashboard\DashboardRequest;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GetSalesInfosController extends Controller
{
    public function __invoke(DashboardRequest $request): JsonResponse
    {
        $this->authorize('viewAny', Sale::class);

        $dataArray = [
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ];

        if (current_user()->hasRole(RoleEnum::COMPANY_OPERATOR)) {
            $dataArray['sellerId'] = current_user()->id;
        }

        $data = SaleInfoData::validateAndCreate($dataArray);

        $salesInfos = app(GetSalesInfosAction::class)
            ->execute($data);

        return response()->json($salesInfos, 200);
    }
}
