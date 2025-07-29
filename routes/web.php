<?php

use App\Utils\SessionUtils;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\EnsureSessionIsValid;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\MappingUserRoleController;
use App\Http\Controllers\MappingRoleMenuPermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Utils\CacheUtils;

Route::middleware([EnsureSessionIsValid::class])->group(function () {

    Route::prefix('login')->group(function () {

        Route::get('/', [AuthController::class, 'login'])->name('login');
        Route::post('/', [AuthController::class, 'doLogin'])->name('login');
    });

    Route::prefix('change-password')->group(function () {
        Route::get('/', [AuthController::class, 'changePassword'])->name('auth-change-password');
        Route::post('/', [AuthController::class, 'doChangePassword'])->name('auth-change-password');
    });

    Route::get('/logout', [AuthController::class, 'doLogout'])->name('logout');

    Route::prefix('choose-role')->group(function () {

        Route::get('/', [AuthController::class, 'chooseRole'])->name('choose-role');
        Route::post('/', [AuthController::class, 'doChooseRole'])->name('choose-role');
    });

    Route::get('/', function() {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permissionIsValid:view');

    Route::prefix( 'profile')->group(function () {
        Route::get('/', [ProfileController::class, 'profile'])->name('profile')->middleware('permissionIsValid:view');
        Route::post('change-profile/{id}', [ProfileController::class, 'changeProfile'])->name('change-profile')->middleware('permissionIsValid:change_profile');
        Route::post('change-password/{id}', [ProfileController::class, 'changePassword'])->name('change-password')->middleware('permissionIsValid:change_password');
    });

    Route::prefix('users')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('users')->middleware('permissionIsValid:view');
        Route::post('/', [UserController::class, 'index'])->name('users')->middleware('permissionIsValid:view');

        Route::prefix('add')->group(function () {

            Route::get('/', [UserController::class, 'create'])->name('users-add')->middleware('permissionIsValid:create');

            Route::post('/', [UserController::class, 'store'])->name('users-add')->middleware('permissionIsValid:create');

        });

        Route::prefix('edit')->middleware('permissionIsValid:update')->group(function () {

            Route::get('{id}', [UserController::class, 'edit'])->name('users-edit')->middleware('permissionIsValid:update');

            Route::post('{id}', [UserController::class, 'update'])->name('users-edit')->middleware('permissionIsValid:update');

        });

        Route::prefix('change-status')->middleware('permissionIsValid:update')->group(function () {

            Route::get('{id}', [UserController::class, 'changeStatus'])->name('users-change-status')->middleware('permissionIsValid:change_status');

            Route::post('{id}', [UserController::class, 'doChangeStatus'])->name('users-change-status')->middleware('permissionIsValid:change_status');

        });

    });

    Route::prefix('settings')->group(function () {

        Route::prefix('statuses')->group(function () {

            Route::get('/', [StatusController::class, 'index'])->name('statuses')->middleware('permissionIsValid:view');

            Route::prefix('add')->group(function () {

                Route::get('/', [StatusController::class, 'create'])->name('statuses-add')->middleware('permissionIsValid:create');

                Route::post('/', [StatusController::class, 'store'])->name('statuses-add')->middleware('permissionIsValid:create');

            });

            Route::prefix('edit')->middleware('permissionIsValid:update')->group(function () {

                Route::get('{id}', [StatusController::class, 'edit'])->name('statuses-edit')->middleware('permissionIsValid:update');

                Route::post('{id}', [StatusController::class, 'update'])->name('statuses-edit')->middleware('permissionIsValid:update');

            });

            Route::get('delete/{id}', [StatusController::class, 'delete'])->name('statuses-delete')->middleware('permissionIsValid:delete');

        });


        Route::prefix('roles')->group(function () {

            Route::get('/', [RoleController::class, 'index'])->name('roles')->middleware('permissionIsValid:view');

            Route::prefix('add')->group(function () {

                Route::get('/', [RoleController::class, 'create'])->name('roles-add')->middleware('permissionIsValid:create');

                Route::post('/', [RoleController::class, 'store'])->name('roles-add')->middleware('permissionIsValid:create');

            });

            Route::prefix('edit')->middleware('permissionIsValid:update')->group(function () {

                Route::get('{id}', [RoleController::class, 'edit'])->name('roles-edit')->middleware('permissionIsValid:update');

                Route::post('{id}', [RoleController::class, 'update'])->name('roles-edit')->middleware('permissionIsValid:update');

            });

            Route::get('delete/{id}', [RoleController::class, 'delete'])->name('roles-delete')->middleware('permissionIsValid:delete');

        });


        Route::prefix('menus')->group(function () {

            Route::get('/', [MenuController::class, 'index'])->name('menus')->middleware('permissionIsValid:view');

            Route::prefix('add')->group(function () {

                Route::get('/', [MenuController::class, 'create'])->name('menus-add')->middleware('permissionIsValid:create');

                Route::post('/', [MenuController::class, 'store'])->name('menus-add')->middleware('permissionIsValid:create');

            });

            Route::prefix('edit')->middleware('permissionIsValid:update')->group(function () {

                Route::get('{id}', [MenuController::class, 'edit'])->name('menus-edit')->middleware('permissionIsValid:update');

                Route::post('{id}', [MenuController::class, 'update'])->name('menus-edit')->middleware('permissionIsValid:update');

            });

            Route::get('delete/{id}', [MenuController::class, 'delete'])->name('menus-delete')->middleware('permissionIsValid:delete');

        });

        Route::prefix('permissions')->group(function () {

            Route::get('/', [PermissionController::class, 'index'])->name('permissions')->middleware('permissionIsValid:view');

            Route::prefix('add')->group(function () {

                Route::get('/', [PermissionController::class, 'create'])->name('permissions-add')->middleware('permissionIsValid:create');

                Route::post('/', [PermissionController::class, 'store'])->name('permissions-add')->middleware('permissionIsValid:create');

            });

            Route::prefix('edit')->middleware('permissionIsValid:update')->group(function () {

                Route::get('{id}', [PermissionController::class, 'edit'])->name('permissions-edit')->middleware('permissionIsValid:update');

                Route::post('{id}', [PermissionController::class, 'update'])->name('permissions-edit')->middleware('permissionIsValid:update');

            });

            Route::get('delete/{id}', [PermissionController::class, 'delete'])->name('permissions-delete')->middleware('permissionIsValid:delete');

        });

        Route::prefix('mapping')->group(function () {

            Route::prefix('roles-menus-permissions')->group(function () {

                Route::get('/', [MappingRoleMenuPermissionController::class, 'index'])->name('roles-menus-permissions')->middleware('permissionIsValid:view');

                Route::prefix('add')->group(function () {

                    Route::get('/', [MappingRoleMenuPermissionController::class, 'create'])->name('roles-menus-permissions-add')->middleware('permissionIsValid:create');

                    Route::post('/', [MappingRoleMenuPermissionController::class, 'store'])->name('roles-menus-permissions-add')->middleware('permissionIsValid:create');

                });

                Route::prefix('edit')->middleware('permissionIsValid:update')->group(function () {

                    Route::get('{role_id}/{menu_id}', [MappingRoleMenuPermissionController::class, 'edit'])->name('roles-menus-permissions-edit')->middleware('permissionIsValid:update');

                    Route::post('{role_id}/{menu_id}', [MappingRoleMenuPermissionController::class, 'update'])->name('roles-menus-permissions-edit')->middleware('permissionIsValid:update');

                });

                Route::get('delete/{role_id}/{menu_id}', [MappingRoleMenuPermissionController::class, 'delete'])->name('roles-menus-permissions-delete')->middleware('permissionIsValid:delete');

            });

            Route::prefix('users-roles')->group(function () {

                Route::get('/', [MappingUserRoleController::class, 'index'])->name('users-roles')->middleware('permissionIsValid:view');

                Route::prefix('add')->group(function () {

                    Route::get('/', [MappingUserRoleController::class, 'create'])->name('users-roles-add')->middleware('permissionIsValid:create');

                    Route::post('/', [MappingUserRoleController::class, 'store'])->name('users-roles-add')->middleware('permissionIsValid:create');

                });

                Route::prefix('edit')->middleware('permissionIsValid:update')->group(function () {

                    Route::get('{user_id}', [MappingUserRoleController::class, 'edit'])->name('users-roles-edit')->middleware('permissionIsValid:update');

                    Route::post('{user_id}', [MappingUserRoleController::class, 'update'])->name('users-roles-edit')->middleware('permissionIsValid:update');

                });

                Route::get('delete/{user_id}', [MappingUserRoleController::class, 'delete'])->name('users-roles-delete')->middleware('permissionIsValid:delete');

            });

        });

    });

    Route::get('/logout', function () {
        $sessionUtils = new SessionUtils();
        $userID = $sessionUtils->get('id');
        CacheUtils::deleteWithTags($userID);
        $sessionUtils->deleteMain();
        return redirect()->route('login');
    })->name('logout');
});
