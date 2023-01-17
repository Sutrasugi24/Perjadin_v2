<?php

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\KuitansiController;
use App\Http\Controllers\PerjadinController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\FileManagerController;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Auth::routes([
    'register'  => false,
    'reset'     => false,
    'confirm'   => false
]);

Route::middleware(['auth'])->get('/home', [DashboardController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(UserController::class)->group(function () {
        Route::get('user', 'index')->middleware(['permission:read user'])->name('user.index');
        Route::post('user', 'store')->middleware(['permission:create user'])->name('user.store');
        Route::post('user/show', 'show')->middleware(['permission:read user'])->name('user.show');
        Route::put('user', 'update')->middleware(['permission:update user'])->name('user.update');
        Route::delete('user', 'destroy')->middleware(['permission:delete user'])->name('user.destroy');
    });

    Route::controller(SuratController::class)->group(function () {
        Route::get('surat', 'index')->middleware(['permission:read surat'])->name('surat.index');
        Route::post('surat', 'store')->middleware(['permission:create surat'])->name('surat.store');
        Route::post('surat/show', 'show')->middleware(['permission:read surat'])->name('surat.show');
        Route::put('surat', 'update')->middleware(['permission:update surat'])->name('surat.update');
        Route::delete('surat', 'destroy')->middleware(['permission:delete surat'])->name('surat.destroy');
    });

    Route::controller(PerjadinController::class)->group(function () {
        Route::get('perjadin', 'index')->middleware(['permission:read perjadin'])->name('perjadin.index');
        Route::post('perjadin', 'store')->middleware(['permission:create perjadin'])->name('perjadin.store');
        Route::post('perjadin/show', 'show')->middleware(['permission:read perjadin'])->name('perjadin.show');
        Route::put('perjadin', 'update')->middleware(['permission:update perjadin'])->name('perjadin.update');
        Route::delete('perjadin', 'destroy')->middleware(['permission:delete perjadin'])->name('perjadin.destroy');
    });

    Route::controller(BiayaController::class)->group(function () {
        Route::get('biaya', 'index')->middleware(['permission:read biaya'])->name('biaya.index');
        Route::post('biaya', 'store')->middleware(['permission:create biaya'])->name('biaya.store');
        Route::post('biaya/show', 'show')->middleware(['permission:read biaya'])->name('biaya.show');
        Route::put('biaya', 'update')->middleware(['permission:update biaya'])->name('biaya.update');
        Route::delete('biaya', 'destroy')->middleware(['permission:delete biaya'])->name('biaya.destroy');
    });

    Route::controller(KuitansiController::class)->group(function () {
        Route::get('kuitansi', 'index')->middleware(['permission:read kuitansi'])->name('kuitansi.index');
        Route::post('kuitansi', 'store')->middleware(['permission:create kuitansi'])->name('kuitansi.store');
        Route::post('kuitansi/show', 'show')->middleware(['permission:read kuitansi'])->name('kuitansi.show');
        Route::put('kuitansi', 'update')->middleware(['permission:update kuitansi'])->name('kuitansi.update');
        Route::delete('kuitansi', 'destroy')->middleware(['permission:delete biaya'])->name('kuitansi.destroy');
    });
    

    Route::controller(RoleController::class)->group(function () {
        Route::get('role', 'index')->middleware(['permission:read role'])->name('role.index');
        Route::post('role', 'store')->middleware(['permission:create role'])->name('role.store');
        Route::post('role/show', 'show')->middleware(['permission:read role'])->name('role.show');
        Route::put('role', 'update')->middleware(['permission:update role'])->name('role.update');
        Route::delete('role', 'destroy')->middleware(['permission:delete role'])->name('role.destroy');
    });

    Route::controller(PermissionController::class)->group(function () {
        Route::get('permission', 'index')->middleware(['permission:read permission'])->name('permission.index');
        Route::post('permission', 'store')->middleware(['permission:create permission'])->name('permission.store');
        Route::post('permission/show', 'show')->middleware(['permission:read permission'])->name('permission.show');
        Route::put('permission', 'update')->middleware(['permission:update permission'])->name('permission.update');
        Route::delete('permission', 'destroy')->middleware(['permission:delete permission'])->name('permission.destroy');
        Route::get('permission/reload', 'reloadPermission')->middleware(['permission:create permission'])->name('permission.reload');
    });

    Route::get('module', [ModuleController::class, 'index'])->middleware(['permission:read module'])->name('module.index');

    Route::get('filemanager', [FileManagerController::class, 'index'])->middleware(['permission:filemanager'])->name('filemanager');

    Route::controller(SettingController::class)->group(function () {
        Route::get('setting', 'index')->middleware(['permission:read setting'])->name('setting.index');
        Route::post('setting', 'store')->middleware(['permission:create setting'])->name('setting.store');
        Route::post('setting/show', 'show')->middleware(['permission:read setting'])->name('setting.show');
        Route::put('setting', 'update')->middleware(['permission:update setting'])->name('setting.update');
        Route::delete('setting', 'destroy')->middleware(['permission:delete setting'])->name('setting.destroy');
    });
});
