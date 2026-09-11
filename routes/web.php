<?php

use App\Livewire\Student\LiveCoursesIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('/live-courses', LiveCoursesIndex::class)->name('live-courses');

});

require __DIR__ . '/settings.php';
