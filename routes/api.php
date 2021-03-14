<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Benborla\Hydra\Http\Controllers\UpdatePermissionsAction;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. You're free to add
| as many additional routes to this file as your tool may require.
|
*/

Route::get('/sync-permissions', UpdatePermissionsAction::class)->name('sync-permission');
Route::get('test', UpdatePermissionsAction::class . '@test')->name('sync-permission-tester');

