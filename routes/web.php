<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MCPController;

// Voice Assistant Dashboard
Route::get('/', function () {
    return view('voice');
});

// Navigation Pages
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/career', function () {
    return view('career');
})->name('career');

// MCP API
Route::post('/mcp', [MCPController::class, 'handle']);
Route::post('/ai-process', [MCPController::class, 'process']);
