<?php

namespace App\Http\Api\Controllers\Admin;

use App\Domain\Account\Actions\User\CreateUserAction;
use App\Domain\Account\Actions\User\DeleteUserAction;
use App\Domain\Account\Actions\User\UpdateUserAction;
use App\Domain\Account\Actions\User\UserData;
use App\Domain\Account\Models\User;
use App\Http\Api\Requests\Admin\UserRequest;
use App\Http\Api\Resources\User\UserResource;
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

        $user = app(UpdateUserAction::class)
            ->execute($user, $data);

        return UserResource::make($user);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        app(DeleteUserAction::class)
            ->execute($user);

        return response()->noContent();
    }
}
