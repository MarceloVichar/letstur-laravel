<?php

namespace Database\Seeders\Data;

use App\Domain\Account\Enums\RoleEnum;
use Illuminate\Support\Collection;

class PermissionsAndRoles
{
    public static function getRoles(): array
    {
        $permissions = fn($key) => static::getPermissions()
            ->get($key)
            ->values();

        return [
            RoleEnum::ADMIN => [
                'users' => $permissions('users'),
            ],

            RoleEnum::COMPANY_OPERATOR => [
                'users' => $permissions('users'),
            ],

            RoleEnum::COMPANY_ADMIN => [
                'users' => $permissions('users'),
            ]
        ];
    }

    public static function getPermissions(): Collection
    {
        return collect([
            'users' => static::crud(),
        ]);
    }

    private static function crud(array $except = []): Collection
    {
        return collect(['view', 'view any', 'create', 'update', 'delete'])
            ->except($except);
    }
}
