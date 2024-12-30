<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\MenuService;
use App\Services\RoleService;
use App\Services\PermissionService;
use App\Services\Impl\AuthServiceImpl;
use App\Services\Impl\MenuServiceImpl;
use App\Services\Impl\RoleServiceImpl;
use Illuminate\Support\ServiceProvider;
use App\Services\MappingRoleMenuService;
use App\Services\MappingUserRoleService;
use App\Services\Impl\PermissionServiceImpl;
use App\Services\MappingMenuPermissionService;
use App\Services\Impl\MappingRoleMenuServiceImpl;
use App\Services\Impl\MappingUserRoleServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Services\Impl\MappingMenuPermissionServiceImpl;
use App\Services\Impl\UserServiceImpl;
use App\Services\UserService;

class UserServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        AuthService::class => AuthServiceImpl::class,
        MenuService::class => MenuServiceImpl::class,
        RoleService::class => RoleServiceImpl::class,
        UserService::class => UserServiceImpl::class,
        PermissionService::class => PermissionServiceImpl::class,
        MappingMenuPermissionService::class => MappingMenuPermissionServiceImpl::class,
        MappingRoleMenuService::class => MappingRoleMenuServiceImpl::class,
        MappingUserRoleService::class => MappingUserRoleServiceImpl::class,
    ];

    public function provides()
    {
        return [
            AuthService::class,
            MenuService::class,
            RoleService::class,
            UserService::class,
            PermissionService::class,
            MappingMenuPermissionService::class,
            MappingRoleMenuService::class,
            MappingUserRoleService::class,
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
