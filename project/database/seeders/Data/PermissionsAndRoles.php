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
                'companies' => $permissions('companies'),
            ],

            RoleEnum::COMPANY_OPERATOR => [
                'users' => $permissions('users'),
            ],

            RoleEnum::COMPANY_ADMIN => [
                'users' => $permissions('users'),
                'companies' => collect(['view', 'update']),
                'drivers' => $permissions('drivers'),
                'vehicles' => $permissions('vehicles'),
                'tour-guides' => $permissions('tour-guides'),
                'locales' => $permissions('locales'),
            ]
        ];
    }

    public static function getPermissions(): Collection
    {
        return collect([
            'users' => static::crud(),
            'companies' => static::crud(),
            'drivers' => static::crud(),
            'vehicles' => static::crud(),
            'tour-guides' => static::crud(),
            'locales' => static::crud(),
        ]);
    }

    private static function crud(array $except = []): Collection
    {
        return collect(['view', 'view any', 'create', 'update', 'delete'])
            ->except($except);
    }
}
