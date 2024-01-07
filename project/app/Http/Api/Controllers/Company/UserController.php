<?php

namespace App\Http\Api\Controllers\Company;

use App\Domain\Account\Actions\User\CreateUserAction;
use App\Domain\Account\Actions\User\DeleteUserAction;
use App\Domain\Account\Actions\User\UpdateUserAction;
use App\Domain\Account\Actions\User\UserData;
use App\Domain\Account\Models\User;
use App\Http\Api\Requests\Company\UserRequest;
use App\Http\Api\Resources\Shared\UserResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class UserController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = app(User::class)
            ->where('company_id', current_user()->company_id);

        return pagination($users)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
                AllowedFilter::partial('role', 'roles.name'),
            ])
            ->with(['roles'])
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

        return response()->json(UserResource::make($user), 200);
    }

    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);

        $data = UserData::validateAndCreate([
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ]);

        $user = app(CreateUserAction::class)
            ->execute($data);

        return response()->json(UserResource::make($user), 201);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = UserData::validateAndCreate($request->validated());

        $user = app(UpdateUserAction::class)
            ->execute($user, $data);

        return response()->json(UserResource::make($user), 200);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        app(DeleteUserAction::class)
            ->execute($user);

        return response()->noContent();
    }
}
