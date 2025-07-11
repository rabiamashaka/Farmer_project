<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UssdController;

Route::post('/ussd', [UssdController::class, 'handler']);