<?php

namespace App\Http\Api\Controllers\Admin;


use App\Domain\Account\Models\User;
use App\Http\Api\Resources\Auth\UserResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class UserController extends ResourceController
{
    public function index()
    {
        return pagination(User::query())
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
            ])
            ->with(['roles'])
            ->allowedSorts(['name', 'email', 'created_at'])
            ->defaultSort('created_at')
            ->resource(UserResource::class);
    }
}
