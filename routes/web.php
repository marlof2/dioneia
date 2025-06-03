<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\Patient;
use App\Livewire\Promptuary;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Users\Index;

Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('auth');

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/users', Index::class)->name('users.index');

    Route::get('/user/profile', Profile::class)->name('user.profile');

    Route::group(['prefix' => 'patients'], function () {
        Route::get('/', Patient\Index::class)->name('patients.index');
        Route::get('/create', Patient\Create::class)->name('patients.create');
        Route::get('/edit/{id}', Patient\Update::class)->name('patients.edit');
    });

    Route::group(['prefix' => 'promptuary'], function () {
        Route::get('/', Promptuary\Index::class)->name('promptuary.index');
        // Route::get('/create', Promptuary\Create::class)->name('promptuary.create');
        // Route::get('/edit/{id}', Promptuary\Update::class)->name('promptuary.edit');
    });
});

require __DIR__ . '/auth.php';
