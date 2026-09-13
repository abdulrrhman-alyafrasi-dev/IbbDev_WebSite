<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Route;

Route::get("/", [QuestionController::class, "index"])->name("home");

// Guest routes
Route::middleware("guest")->group(function () {
    Route::get("register", [AuthController::class, "showRegister"])->name("register");
    Route::post("register", [AuthController::class, "register"]);
    Route::get("login", [AuthController::class, "showLogin"])->name("login");
    Route::post("login", [AuthController::class, "login"]);
});

// Authenticated routes
Route::middleware("auth")->group(function () {
    Route::post("logout", [AuthController::class, "logout"])->name("logout");
    Route::resource("questions", QuestionController::class)->only(["create", "store"]);
    Route::post("questions/{question}/answers", [AnswerController::class, "store"])->name("answers.store");
    Route::post("answers/{answer}/accept", [AnswerController::class, "accept"])->name("answers.accept");
});

// Public routes
Route::get("questions", [QuestionController::class, "index"])->name("questions.index");
Route::get("questions/{question}", [QuestionController::class, "show"])->name("questions.show");
