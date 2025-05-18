<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\Patient\Create;
use App\Livewire\Patient\Index as PatientIndex;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Users\Index;

Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('auth');

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/users', Index::class)->name('users.index');

    Route::get('/user/profile', Profile::class)->name('user.profile');

    Route::group(['prefix' => 'patients'], function () {
        Route::get('/', PatientIndex::class)->name('patients.index');
        Route::get('/create', Create::class)->name('patients.create');
    });
});

require __DIR__ . '/auth.php';
