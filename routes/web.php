<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpreadsheetController;

Route::get('/observations', [SpreadsheetController::class, 'exportObservations']);
Route::get('/mesa', [SpreadsheetController::class, 'exportMesa']);
