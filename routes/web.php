<?php

use App\Http\Controllers\ActionsController;
use App\Http\Controllers\BrigadesController;
use App\Http\Controllers\DaysController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Кроме авторизации ничего не нужно
Auth::routes(['register' => false, 'verify' => false, 'reset' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('users')->group(function()
{
    Route::get('/', 'App\Http\Controllers\UsersController')->name('users');
    Route::get('get_users', [App\Http\Controllers\UsersController::class, 'getUsers'])->name('getUsers');
    Route::get('get_current_user', [App\Http\Controllers\UsersController::class, 'getCurrentUser'])->name('getCurrentUser');
    Route::delete('delete_users', [App\Http\Controllers\UsersController::class, 'deleteUsers'])->name('deleteUsers');
    Route::post('update_user', [App\Http\Controllers\UsersController::class, 'updateUser'])->name('updateUser');
    Route::post('create_user', [App\Http\Controllers\UsersController::class, 'createUser'])->name('createUser');
    Route::post('update_user_password', [App\Http\Controllers\UsersController::class, 'updateUserPassword'])->name('updateUserPassword');
});

Route::prefix('actions')->group(function()
{
    Route::get('/', 'App\Http\Controllers\ActionsController')->name('actions');
    Route::get('get_actions', [ActionsController::class, 'getActions'])->name('getActions');
    Route::delete('delete_actions', [ActionsController::class, 'deleteActions'])->name('deleteActions');
    Route::post('update_action', [ActionsController::class, 'updateAction'])->name('updateAction');
    Route::post('create_action', [ActionsController::class, 'createAction'])->name('createAction');
    Route::get('get_raw_actions', [ActionsController::class, 'getActionsSelect'])->name('getActionsSelect');
});

Route::prefix('brigades')->group(function()
{
    Route::get('', 'App\Http\Controllers\BrigadesController')->name('brigades');
    Route::get('get_brigades', [BrigadesController::class, 'getBrigades'])->name('getBrigades');
    Route::post('create_brigade', [BrigadesController::class, 'createBrigade'])->name('createBrigade');
    Route::delete('delete_brigades', [BrigadesController::class, 'deleteBrigades'])->name('deleteBrigades');
    Route::post('update_brigade', [BrigadesController::class, 'updateBrigade'])->name('updateBrigade');
});

Route::prefix('deliveries')->group(function()
{
    Route::get('/', 'App\Http\Controllers\DeliveryController')->name('delivery');
    Route::post('get_deliveries', [DeliveryController::class, 'getDeliveries'])->name('getDeliveries');
    Route::delete('delete_deliveries', [DeliveryController::class, 'deleteDeliveries'])->name('deleteDeliveries');
    Route::post('create_delivery', [DeliveryController::class, 'createDelivery'])->name('createDelivery');
    Route::post('update_delivery', [DeliveryController::class, 'updateDelivery'])->name('updateDelivery');
    Route::post('get_values', [DeliveryController::class, 'getValues'])->name('getValues');
});

Route::prefix('schedule')->group(function()
{
    Route::get('/', 'App\Http\Controllers\ScheduleController')->name('schedule');
    Route::post('get_schedule', [ScheduleController::class, 'getSchedule'])->name('getSchedule');
    Route::post('set_brigade_to_delivery', [ScheduleController::class, 'setBrigadeToDelivery'])->name('setBrigadeToDelivery');
});

Route::prefix('days')->group(function()
{
    Route::post('get_day', [DaysController::class, 'getDay'])->name('getDay');
    Route::post('set_day_value', [DaysController::class, 'setDayValue'])->name('setDayValue');
    Route::post('add_brigade', [DaysController::class, 'addBrigade'])->name('addBrigade');
    Route::post('remove_brigade', [DaysController::class, 'removeBrigade'])->name('removeBrigade');
});
