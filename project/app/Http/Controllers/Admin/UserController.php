<?php

namespace App\Http\Controllers\Admin;


use App\Domain\Account\Models\User;
use App\Http\Controllers\ResourceController;
use App\Http\Resources\Auth\UserResource;
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
