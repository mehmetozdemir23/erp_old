<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        $this->registerGates();
    }

    protected function registerGates(): void
    {
        try {
            foreach (Permission::pluck('name') as $permission) {
                Gate::define($permission, function ($user) use ($permission) {
                    return $user->hasPermission($permission);
                });
            }
        } catch (\Exception $e) {
            info('registerPermissions(): Database not found or not yet migrated. Ignoring user permissions while booting app.');
        }
    }
}
