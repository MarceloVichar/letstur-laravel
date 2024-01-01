<?php
/**
 * All files in this folder will be included in the application.
 */

if (! function_exists('current_user')) {
    /**
     * Retorna uma instância do usuário corrente.
     *
     * @return \App\Domain\Account\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    function current_user(): ?App\Domain\Account\Models\User
    {
        return auth()->user();
    }
}

if (! function_exists('iso8601')) {
    function iso8601($date): ?string
    {
        if (! $date) {
            return null;
        }

        return (new \Carbon\Carbon($date))->toIso8601String();
    }
}

if (! function_exists('output_date_format')) {
    function output_date_format($date): ?string
    {
        return iso8601($date);
    }
}

if (! function_exists('pagination')) {
    /**
     * Retorna uma instância do builder de paginação.
     *
     * @return \App\Support\PaginationBuilder
     */
    function pagination($subject): App\Support\PaginationBuilder
    {
        return \App\Support\PaginationBuilder::for($subject);
    }
}
