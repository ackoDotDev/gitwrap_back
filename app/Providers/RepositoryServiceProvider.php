<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            \App\Repositories\Contracts\UserRepository::class,
            static function () {
                return new \App\Repositories\UserRepository(new \App\Models\User());
            }
        );
    }
}
