<?php

namespace App\Http\Api\Controllers\Company\Company;

use App\Http\Api\Resources\Shared\CompanyResource;
use App\Http\Shared\Controllers\Controller;

class GetUserCompany extends Controller
{
    public function __invoke()
    {
        $company = current_user()->company()->first();

        $this->authorize('view', $company);

        return response()->json(CompanyResource::make($company), 200);
    }
}
