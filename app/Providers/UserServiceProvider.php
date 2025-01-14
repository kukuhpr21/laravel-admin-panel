<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\MenuService;
use App\Services\RoleService;
use App\Services\UserService;
use App\Services\PermissionService;
use App\Services\Impl\AuthServiceImpl;
use App\Services\Impl\MenuServiceImpl;
use App\Services\Impl\RoleServiceImpl;
use App\Services\Impl\UserServiceImpl;
use Illuminate\Support\ServiceProvider;
use App\Services\MappingUserRoleService;
use App\Services\Impl\PermissionServiceImpl;
use App\Services\Impl\MappingUserRoleServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Services\Impl\MappingRoleMenuPermissionServiceImpl;
use App\Services\MappingRoleMenuPermissionService;

class UserServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        AuthService::class => AuthServiceImpl::class,
        MenuService::class => MenuServiceImpl::class,
        RoleService::class => RoleServiceImpl::class,
        UserService::class => UserServiceImpl::class,
        PermissionService::class => PermissionServiceImpl::class,
        MappingUserRoleService::class => MappingUserRoleServiceImpl::class,
        MappingRoleMenuPermissionService::class => MappingRoleMenuPermissionServiceImpl::class,
    ];

    public function provides()
    {
        return [
            AuthService::class,
            MenuService::class,
            RoleService::class,
            UserService::class,
            PermissionService::class,
            MappingUserRoleService::class,
            MappingRoleMenuPermissionService::class,
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
