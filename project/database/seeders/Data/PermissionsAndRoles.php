<?php

namespace Database\Seeders\Data;

use App\Domain\Account\Enums\RoleEnum;
use Illuminate\Support\Collection;

class PermissionsAndRoles
{
    public static function getRoles(): array
    {
        $permissions = fn ($key) => static::getPermissions()
            ->get($key)
            ->values();

        return [
            RoleEnum::ADMIN => [
                'users' => $permissions('users'),
                'companies' => $permissions('companies'),
            ],

            RoleEnum::COMPANY_OPERATOR => [
                'events' => collect(['view', 'view any']),
                'tours' => collect(['view', 'view any']),
                'sales' => collect(['view', 'view any', 'create', 'update', 'delete']),
            ],

            RoleEnum::COMPANY_ADMIN => [
                'users' => $permissions('users'),
                'companies' => collect(['view', 'update']),
                'drivers' => $permissions('drivers'),
                'vehicles' => $permissions('vehicles'),
                'tour-guides' => $permissions('tour-guides'),
                'locales' => $permissions('locales'),
                'tour-types' => $permissions('tour-types'),
                'tours' => $permissions('tours'),
                'events' => $permissions('events'),
                'sales' => collect(['view', 'view any', 'confirm', 'delete']),
            ],
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
            'tour-types' => static::crud(),
            'tours' => static::crud(),
            'events' => static::crud(),
            'sales' => static::crud()
                ->push(['confirm']),
        ]);
    }

    private static function crud(array $except = []): Collection
    {
        return collect(['view', 'view any', 'create', 'update', 'delete'])
            ->except($except);
    }
}
