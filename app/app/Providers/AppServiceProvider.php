<?php

namespace App\Providers;

use App\Models\User;
use App\Rules;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction());

        Gate::define(Rules::Checker1->value, function (User $user) {
            return $user->role == Rules::Checker1->value ;
        });
        Gate::define(Rules::Checker2->value, function (User $user) {
            return $user->role == Rules::Checker2->value ;
        });
        Gate::define(Rules::Checker3->value, function (User $user) {
            return $user->role == Rules::Checker3->value ;
        });
        Gate::define(Rules::AdminSales->value, function (User $user) {
            return $user->role == Rules::AdminSales->value ;
        });
        Gate::define(Rules::AdminWarehouse->value, function (User $user) {
            return $user->role == Rules::AdminWarehouse->value ;
        });
        Gate::define(Rules::Administrator->value, function (User $user) {
            return $user->role == Rules::Administrator->value ;
        });

    }
}
