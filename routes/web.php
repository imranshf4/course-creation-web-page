<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller((CourseController::class))->group(function () {
    // Route::get('/courses', 'index')->name('courses.index');
    // Route::get('/courses/create', 'create')->name('courses.create');
    Route::post('/courses', 'store')->name('courses.store');
    // Route::get('/courses/{course}', 'show')->name('courses.show');
    // Route::get('/courses/{course}/edit', 'edit')->name('courses.edit');
    // Route::put('/courses/{course}', 'update')->name('courses.update');
    // Route::delete('/courses/{course}', 'destroy')->name('courses.destroy');
});