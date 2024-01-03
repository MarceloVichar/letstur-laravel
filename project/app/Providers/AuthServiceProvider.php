<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Domain\Account\Models\Company;
use App\Domain\Account\Models\User;
use App\Domain\Account\Policies\CompanyPolicy;
use App\Domain\Account\Policies\UserPolicy;
use App\Domain\Records\Models\Driver;
use App\Domain\Records\Policies\DriverPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Company::class => CompanyPolicy::class,
        Driver::class => DriverPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
