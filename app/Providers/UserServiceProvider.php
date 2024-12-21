<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\Impl\AuthServiceImpl;
use App\Services\Impl\MappingMenuPermissionServiceImpl;
use App\Services\Impl\MenuServiceImpl;
use App\Services\Impl\PermissionServiceImpl;
use App\Services\Impl\RoleServiceImpl;
use App\Services\MappingMenuPermissionService;
use App\Services\MenuService;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        AuthService::class => AuthServiceImpl::class,
        MenuService::class => MenuServiceImpl::class,
        RoleService::class => RoleServiceImpl::class,
        PermissionService::class => PermissionServiceImpl::class,
        MappingMenuPermissionService::class => MappingMenuPermissionServiceImpl::class,
    ];

    public function provides()
    {
        return [
            AuthService::class,
            MenuService::class,
            RoleService::class,
            PermissionService::class,
            MappingMenuPermissionService::class,
        ];
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
