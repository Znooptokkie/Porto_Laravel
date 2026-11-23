<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeetcodeController;
use App\Http\Controllers\LinuxCommandsController;
use App\Http\Controllers\ProjectDetailController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ShellScriptsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/opleidingen', CoursesController::class)->defaults('locale', 'nl')->name('courses');
Route::get('/courses', CoursesController::class)->defaults('locale', 'en')->name('en.courses');

Route::get('/over-mij', AboutController::class)->defaults('locale', 'nl')->name('about');
Route::get('/about-me', AboutController::class)->defaults('locale', 'en')->name('en.about');
Route::post('/over-mij/contact', ContactController::class)->defaults('locale', 'nl')->middleware('throttle:5,1')->name('about.contact');
Route::post('/about-me/contact', ContactController::class)->defaults('locale', 'en')->middleware('throttle:5,1')->name('en.about.contact');

Route::get('/projecten', ProjectsController::class)->defaults('locale', 'nl')->name('projects');
Route::get('/projects', ProjectsController::class)->defaults('locale', 'en')->name('en.projects');

Route::get('/projecten/{project:slug}', ProjectDetailController::class)->defaults('locale', 'nl')->name('projects.show');
Route::get('/projects/{project:slug}', ProjectDetailController::class)->defaults('locale', 'en')->name('en.projects.show');

Route::get('/leetcode', LeetcodeController::class)->name('leetcode');
Route::get('/linux-commands', LinuxCommandsController::class)->name('linux-commands');
Route::get('/shell-scripts', ShellScriptsController::class)->name('shell-scripts');
