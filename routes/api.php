<?php

use App\Http\Controllers\Api\ZkAttendanceController;
use App\Http\Middleware\ZkApiKey;
use Illuminate\Support\Facades\Route;

Route::middleware(ZkApiKey::class)->prefix('zk')->group(function () {
    Route::get('/health', [ZkAttendanceController::class, 'health']);
    Route::post('/attendance/ingest', [ZkAttendanceController::class, 'ingest']);
    Route::get('/users/pending-device-sync', [ZkAttendanceController::class, 'pendingNameSync']);
    Route::post('/users/device-sync-ack', [ZkAttendanceController::class, 'ackNameSync']);
    Route::patch('/users/{employeeKey}', [ZkAttendanceController::class, 'updateUser']);
});
