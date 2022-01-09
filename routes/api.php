<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



//Pubic Routes
Route::resource('note', NoteController::class);

// register and login
Route::post('/register', [UserController::class, 'register']);

//Protected Routes
