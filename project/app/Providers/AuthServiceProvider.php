<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Domain\Account\Models\Company;
use App\Domain\Account\Models\User;
use App\Domain\Account\Policies\CompanyPolicy;
use App\Domain\Account\Policies\UserPolicy;
use App\Domain\Records\Models\Driver;
use App\Domain\Records\Models\Locale;
use App\Domain\Records\Models\Tour;
use App\Domain\Records\Models\TourGuide;
use App\Domain\Records\Models\TourType;
use App\Domain\Records\Models\Vehicle;
use App\Domain\Records\Policies\DriverPolicy;
use App\Domain\Records\Policies\LocalePolicy;
use App\Domain\Records\Policies\TourGuidePolicy;
use App\Domain\Records\Policies\TourPolicy;
use App\Domain\Records\Policies\TourTypePolicy;
use App\Domain\Records\Policies\VehiclePolicy;
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
        Driver::class => DriverPolicy::class,
        Vehicle::class => VehiclePolicy::class,
        TourGuide::class => TourGuidePolicy::class,
        Locale::class => LocalePolicy::class,
        TourType::class => TourTypePolicy::class,
        Tour::class => TourPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
