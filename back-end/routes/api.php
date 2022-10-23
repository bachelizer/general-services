<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OfficeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\OfficeEquipmentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\InventoryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/offices',[OfficeController::class, 'index']);
Route::get('/offices/{id}',[OfficeController::class, 'show']);
Route::post('/offices',[OfficeController::class, 'store']);
Route::put('/offices/{id}',[OfficeController::class, 'update']);
Route::get('/office-equipment', [OfficeController::class, 'officeEquipments']);

// Route::apiResource('users', UserController::class);
Route::get('/users',[UserController::class, 'index']);
Route::post('/users',[UserController::class, 'store']);
Route::put('/users/{id}',[UserController::class, 'update']);

Route::get('/equipments',[EquipmentController::class, 'index']);
Route::get('/equipments/{id}',[EquipmentController::class, 'show']);
Route::post('/equipments',[EquipmentController::class, 'store']);
Route::put('/equipments',[EquipmentController::class, 'update']);

Route::get('office-equipments', [OfficeEquipmentController::class, 'index']);
Route::get('office-equipments/{id}', [OfficeEquipmentController::class, 'show']);
Route::post('office-equipments', [OfficeEquipmentController::class, 'store']);
Route::get('office-equipment-maintenance-notification', [OfficeEquipmentController::class, 'regularMaintenanceNotification']);
Route::put('office-equipments/regular-maintenace/{id}',[OfficeEquipmentController::class, 'regularOfficeEquipmentMaintenance']);


Route::get('maintenances', [MaintenanceController::class, 'index']);
Route::get('maintenances/{id}', [MaintenanceController::class, 'show']);
Route::post('maintenances', [MaintenanceController::class, 'store']);
Route::put('maintenances/approval/{id}', [MaintenanceController::class, 'approval']); // update approval status
Route::put('maintenances', [MaintenanceController::class, 'update']); // after the maintenance update the request 
Route::put('maintenances/served/{id}', [MaintenanceController::class, 'served']);
Route::put('maintenances/evaluate/{id}', [MaintenanceController::class, 'evaluate']);
Route::get('/maintenances/report/{startDate}/{endDate}',[MaintenanceController::class, 'report']);
Route::get('/maintenances/report/generate-pdf',[MaintenanceController::class, 'generatePDF']);
Route::get('/maintenance/statistics',[MaintenanceController::class, 'serviceDashboardStatistics']);

Route::get('/services',[ServiceTypeController::class, 'index']);

Route::get('/borrows',[BorrowController::class, 'index']);
Route::post('/borrows',[BorrowController::class, 'store']);
Route::put('/borrows/approve/{id}',[BorrowController::class, 'approve']);
Route::put('/borrows/reject/{id}',[BorrowController::class, 'reject']);
Route::put('/borrows/return/{id}',[BorrowController::class, 'return']);
Route::get('/borrows/report/{startDate}/{endDate}',[BorrowController::class, 'report']);
Route::get('/borrows/report/generate-pdf',[BorrowController::class, 'generatePDF']);
Route::get('/borrows/statistics', [BorrowController::class, 'borrowDashBoardStatistics']);

Route::get('/roles',[RoleController::class, 'index']);

Route::post('/account',[AccountController::class, 'store']);
Route::post('/login',[AccountController::class, 'login']);

Route::get('/inventory', [InventoryController:: class, 'index']);
Route::post('/inventory', [InventoryController:: class, 'store']);
Route::put('/inventory/replenish/{id}', [InventoryController:: class, 'replenish']); 
Route::put('/inventory/despense/{id}', [InventoryController:: class, 'despense']);