<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Utils\SessionUtils;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureSessionIsValid;

Route::middleware([EnsureSessionIsValid::class])->group(function () {

    Route::prefix('login')->group(function () {

        Route::get('/', [AuthController::class, 'login'])->name('login');
        Route::post('/', [AuthController::class, 'doLogin'])->name('login');
    });

    Route::prefix('choose-role')->group(function () {

        Route::get('/', [AuthController::class, 'chooseRole'])->name('choose-role');
        Route::post('/', [AuthController::class, 'doChooseRole'])->name('choose-role');
    });

    Route::get('/', function() {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('settings')->group(function () {

        Route::prefix('roles')->group(function () {

            Route::get('/', [RoleController::class, 'index'])->name('roles');

            Route::prefix('add')->group(function () {

                Route::get('/', [RoleController::class, 'create'])->name('roles-add');

                Route::post('/', [RoleController::class, 'store'])->name('roles-add');

            });

            Route::prefix('edit')->group(function () {

                Route::get('{id}', [RoleController::class, 'edit'])->name('roles-edit');

                Route::post('{id}', [RoleController::class, 'update'])->name('roles-edit');

            });

            Route::get('delete/{id}', [RoleController::class, 'delete'])->name('roles-delete');

        });


        Route::prefix('menus')->group(function () {

            Route::get('/', [MenuController::class, 'index'])->name('menus');

            Route::prefix('add')->group(function () {

                Route::get('/', [MenuController::class, 'create'])->name('menus-add');

                Route::post('/', [MenuController::class, 'store'])->name('menus-add');

            });

            Route::prefix('edit')->group(function () {

                Route::get('{id}', [MenuController::class, 'edit'])->name('menus-edit');

                Route::post('{id}', [MenuController::class, 'update'])->name('menus-edit');

            });

            Route::get('delete/{id}', [MenuController::class, 'delete'])->name('menus-delete');

        });

        Route::prefix('permissions')->group(function () {

            Route::get('/', [PermissionController::class, 'index'])->name('permissions');

            Route::prefix('add')->group(function () {

                Route::get('/', [PermissionController::class, 'create'])->name('permissions-add');

                Route::post('/', [PermissionController::class, 'store'])->name('permissions-add');

            });

            Route::prefix('edit')->group(function () {

                Route::get('{id}', [PermissionController::class, 'edit'])->name('permissions-edit');

                Route::post('{id}', [PermissionController::class, 'update'])->name('permissions-edit');

            });

            Route::get('delete/{id}', [PermissionController::class, 'delete'])->name('permissions-delete');

        });

        Route::prefix('mapping')->group(function () {

            Route::prefix('menus-permissions')->group(function () {

                Route::get('/', [MappingController::class, 'menuPermission'])->name('menus-permissions');

                Route::post('/', [MappingController::class, 'mappingMenuPermission'])->name('menus-permissions');

            });

            Route::prefix('roles-menus')->group(function () {

                Route::get('/', [MappingController::class, 'roleMenu'])->name('roles-menus');

                Route::post('/', [MappingController::class, 'mappingRoleMenu'])->name('roles-menus');

            });

            Route::prefix('users-roles')->group(function () {

                Route::get('/', [MappingController::class, 'userRole'])->name('users-roles');

                Route::post('/', [MappingController::class, 'mappingUserRole'])->name('users-roles');

            });

            Route::prefix('users-menus')->group(function () {

                Route::get('/', [MappingController::class, 'userMenu'])->name('users-menus');

                Route::post('/', [MappingController::class, 'mappingUserMenu'])->name('users-menus');

            });

        });

    });


    Route::get('/logout', function () {
        $sessionUtils = new SessionUtils();
        $sessionUtils->deleteMain();
        return redirect()->route('login');
    })->name('logout');
});
