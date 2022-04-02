<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::unguard();
        Paginator::useBootstrap();

        Gate::define('ogrenci', function (User $user) {
            return ($user->role == "Öğrenci");
        });

        Gate::define('danisman', function (User $user) {
            return ($user->role == "Proje Yürütücüsü");
        });

        Gate::define('sistemyoneticisi', function (User $user) {
            return ($user->role == "Sistem Yöneticisi");
        });

        Blade::if('ogrenci', function () {
            return request()->user()?->can('ogrenci');
        });

        Blade::if('danisman', function () {
            return request()->user()?->can('danisman');
        });

        Blade::if('sistemyoneticisi', function () {
            return request()->user()?->can('sistemyoneticisi');
        });

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);
    }
}
