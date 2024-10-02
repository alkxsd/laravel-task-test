<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index'); // Updated route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Locale switcher
    Route::get('/locale/{locale}', function (string $locale) {
        if (! in_array($locale, ['en', 'es'])) {
            abort(400);
        }
        App::setLocale($locale);
        Session::put('locale', $locale);

        return redirect()->back();

    })->name('setLocale');
});
