<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Gate::define('isTim', function ($user) {
            return $user->role == 'tim';
        });

        Gate::define('isMahasiswa', function ($user) {
            return $user->role == 'mahasiswa';
        });

        Gate::define('isDosenPembimbing', function ($user) {
            return $user->role == 'dosen_pembimbing' || $user->role == 'dosen';
        });

        Gate::define('isDosenPenguji', function ($user) {
            return $user->role == 'dosen_penguji' || $user->role == 'dosen';
        });

        Gate::define('isDosen', function ($user) {
            return $user->role == 'dosen_pembimbing' || $user->role == 'dosen_penguji' || $user->role == 'dosen';
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
