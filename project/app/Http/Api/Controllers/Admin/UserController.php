<?php

namespace App\Http\Api\Controllers\Admin;

use App\Domain\Account\Actions\User\CreateUserAction;
use App\Domain\Account\Actions\User\DeleteCompanyAction;
use App\Domain\Account\Actions\User\UpdateCompanyAction;
use App\Domain\Account\Actions\User\UserData;
use App\Domain\Account\Models\User;
use App\Http\Api\Requests\Admin\UserRequest;
use App\Http\Api\Resources\Shared\UserResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class UserController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return pagination(User::query())
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
            ])
            ->with(['roles', 'company'])
            ->allowedSorts(['name', 'email', 'created_at'])
            ->defaultSort('created_at')
            ->resource(UserResource::class);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->loadMissing([
            'roles',
            'company',
        ]);

        return UserResource::make($user);
    }

    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);

        $data = UserData::validateAndCreate($request->validated());

        $user = app(CreateUserAction::class)
            ->execute($data);

        return UserResource::make($user);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = UserData::validateAndCreate($request->validated());

        $user = app(UpdateCompanyAction::class)
            ->execute($user, $data);

        return UserResource::make($user);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        app(DeleteCompanyAction::class)
            ->execute($user);

        return response()->noContent();
    }
}
