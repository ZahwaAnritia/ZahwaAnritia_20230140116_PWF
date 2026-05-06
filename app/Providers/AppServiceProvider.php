<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Str;
use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

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
        // 1. Konfigurasi Scramble (Dokumentasi API)
        Scramble::configure()
            ->routes(function (Route $route) {
                return Str::startsWith($route->uri, 'api/');
            });

        Scramble::extendOpenApi(function (OpenApi $openApi) {
        $openApi->secure(
            SecurityScheme::http('bearer')
        );
    });

        // 2. Gate untuk izin melihat dokumentasi API
        Gate::define('viewApiDocs', function () {
            return true;
        });

        // 3. Gate untuk role Admin (yang sudah kamu buat sebelumnya)
        Gate::define('manage-product', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('isAdmin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}