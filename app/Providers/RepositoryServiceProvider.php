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

        $this->app->singleton(
            \App\Repositories\Contracts\GitTokenRepository::class,
            static function () {
                return new \App\Repositories\GitTokenRepository(new \App\Models\GitToken());
            }
        );

        $this->app->singleton(
            \App\Repositories\Contracts\UserBrowserRepository::class,
            static function () {
                return new \App\Repositories\UserBrowserRepository(new \App\Models\UserBrowser());
            }
        );

        $this->app->singleton(
            \App\Repositories\Contracts\UserTokenRepository::class,
            static function () {
                return new \App\Repositories\UserTokenRepository(new \App\Models\UserToken());
            }
        );
    }
}
