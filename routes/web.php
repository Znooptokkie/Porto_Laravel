<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectDetailController;
use App\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/opleidingen', CoursesController::class)->name('courses');
Route::get('/projecten', ProjectsController::class)->name('projects');
Route::get('/projecten/{project:slug}', ProjectDetailController::class)->name('projects.show');
