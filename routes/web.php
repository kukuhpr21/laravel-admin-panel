<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MappingMenuPermissionController;
use App\Http\Controllers\MappingRoleMenuController;
use App\Http\Controllers\MappingUserMenuController;
use App\Http\Controllers\MappingUserRoleController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Utils\SessionUtils;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureSessionIsValid;

Route::middleware([EnsureSessionIsValid::class])->group(function () {

    Route::prefix('login')->group(function () {

        Route::get('/', [AuthController::class, 'login'])->name('login');
        Route::post('/', [AuthController::class, 'doLogin'])->name('logout');
    });

    Route::get('/logout', [AuthController::class, 'doLogout'])->name('login');

    Route::prefix('choose-role')->group(function () {

        Route::get('/', [AuthController::class, 'chooseRole'])->name('choose-role');
        Route::post('/', [AuthController::class, 'doChooseRole'])->name('choose-role');
    });

    Route::get('/', function() {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permissionIsValid:view');

    Route::prefix('settings')->group(function () {

        Route::prefix('roles')->group(function () {

            Route::get('/', [RoleController::class, 'index'])->name('roles')->middleware('permissionIsValid:view');

            Route::prefix('add')->group(function () {

                Route::get('/', [RoleController::class, 'create'])->name('roles-add');

                Route::post('/', [RoleController::class, 'store'])->name('roles-add');

            })->middleware('permissionIsValid:create');

            Route::prefix('edit')->group(function () {

                Route::get('{id}', [RoleController::class, 'edit'])->name('roles-edit');

                Route::post('{id}', [RoleController::class, 'update'])->name('roles-edit');

            })->middleware('permissionIsValid:update');

            Route::get('delete/{id}', [RoleController::class, 'delete'])->name('roles-delete')->middleware('permissionIsValid:delete');

        });


        Route::prefix('menus')->group(function () {

            Route::get('/', [MenuController::class, 'index'])->name('menus')->middleware('permissionIsValid:view');

            Route::prefix('add')->group(function () {

                Route::get('/', [MenuController::class, 'create'])->name('menus-add');

                Route::post('/', [MenuController::class, 'store'])->name('menus-add');

            })->middleware('permissionIsValid:create');

            Route::prefix('edit')->group(function () {

                Route::get('{id}', [MenuController::class, 'edit'])->name('menus-edit');

                Route::post('{id}', [MenuController::class, 'update'])->name('menus-edit');

            })->middleware('permissionIsValid:update');

            Route::get('delete/{id}', [MenuController::class, 'delete'])->name('menus-delete')->middleware('permissionIsValid:delete');

        });

        Route::prefix('permissions')->group(function () {

            Route::get('/', [PermissionController::class, 'index'])->name('permissions')->middleware('permissionIsValid:view');

            Route::prefix('add')->group(function () {

                Route::get('/', [PermissionController::class, 'create'])->name('permissions-add');

                Route::post('/', [PermissionController::class, 'store'])->name('permissions-add');

            })->middleware('permissionIsValid:create');

            Route::prefix('edit')->group(function () {

                Route::get('{id}', [PermissionController::class, 'edit'])->name('permissions-edit');

                Route::post('{id}', [PermissionController::class, 'update'])->name('permissions-edit');

            })->middleware('permissionIsValid:update');

            Route::get('delete/{id}', [PermissionController::class, 'delete'])->name('permissions-delete')->middleware('permissionIsValid:delete');

        });

        Route::prefix('mapping')->group(function () {

            Route::prefix('menus-permissions')->group(function () {

                Route::get('/', [MappingMenuPermissionController::class, 'index'])->name('menus-permissions')->middleware('permissionIsValid:view');

                Route::prefix('add')->group(function () {

                    Route::get('/', [MappingMenuPermissionController::class, 'create'])->name('menus-permissions-add');

                    Route::post('/', [MappingMenuPermissionController::class, 'store'])->name('menus-permissions-add');

                })->middleware('permissionIsValid:create');

                Route::prefix('edit')->group(function () {

                    Route::get('{menu_id}', [MappingMenuPermissionController::class, 'edit'])->name('menus-permissions-edit');

                    Route::post('{menu_id}', [MappingMenuPermissionController::class, 'update'])->name('menus-permissions-edit');

                })->middleware('permissionIsValid:update');

                Route::get('delete/{menu_id}', [MappingMenuPermissionController::class, 'delete'])->name('menus-permissions-delete')->middleware('permissionIsValid:delete');

            });

            Route::prefix('roles-menus')->group(function () {

                Route::get('/', [MappingRoleMenuController::class, 'index'])->name('roles-menus')->middleware('permissionIsValid:view');

                Route::prefix('add')->group(function () {

                    Route::get('/', [MappingRoleMenuController::class, 'create'])->name('roles-menus-add');

                    Route::post('/', [MappingRoleMenuController::class, 'store'])->name('roles-menus-add');

                })->middleware('permissionIsValid:create');

                Route::prefix('edit')->group(function () {

                    Route::get('{role_id}', [MappingRoleMenuController::class, 'edit'])->name('roles-menus-edit');

                    Route::post('{role_id}', [MappingRoleMenuController::class, 'update'])->name('roles-menus-edit');

                })->middleware('permissionIsValid:update');

                Route::get('delete/{role_id}', [MappingRoleMenuController::class, 'delete'])->name('roles-menus-delete')->middleware('permissionIsValid:delete');

            });

            Route::prefix('users-roles')->group(function () {

                Route::get('/', [MappingUserRoleController::class, 'index'])->name('users-roles')->middleware('permissionIsValid:view');

                Route::prefix('add')->group(function () {

                    Route::get('/', [MappingUserRoleController::class, 'create'])->name('users-roles-add');

                    Route::post('/', [MappingUserRoleController::class, 'store'])->name('users-roles-add');

                })->middleware('permissionIsValid:create');

                Route::prefix('edit')->group(function () {

                    Route::get('{user_id}', [MappingUserRoleController::class, 'edit'])->name('users-roles-edit');

                    Route::post('{user_id}', [MappingUserRoleController::class, 'update'])->name('users-roles-edit');

                })->middleware('permissionIsValid:update');

                Route::get('delete/{user_id}', [MappingUserRoleController::class, 'delete'])->name('users-roles-delete')->middleware('permissionIsValid:delete');

            });

            Route::prefix('users-menus')->group(function () {

                Route::get('/', [MappingUserMenuController::class, 'index'])->name('users-menus')->middleware('permissionIsValid:view');

                Route::prefix('add')->group(function () {

                    Route::get('/', [MappingUserMenuController::class, 'create'])->name('users-menus-add');

                    Route::post('/', [MappingUserMenuController::class, 'store'])->name('users-menus-add');

                })->middleware('permissionIsValid:create');

                Route::prefix('edit')->group(function () {

                    Route::get('{user_id}', [MappingUserMenuController::class, 'edit'])->name('users-menus-edit');

                    Route::post('{user_id}', [MappingUserMenuController::class, 'update'])->name('users-menus-edit');

                })->middleware('permissionIsValid:update');

                Route::get('delete/{user_id}', [MappingUserMenuController::class, 'delete'])->name('users-menus-delete')->middleware('permissionIsValid:delete');

            });

        });

    });

    Route::get('/logout', function () {
        $sessionUtils = new SessionUtils();
        $sessionUtils->deleteMain();
        return redirect()->route('login');
    })->name('logout');
});
