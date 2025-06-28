<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\Patient;
use App\Livewire\Promptuary;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Users\Index;
use App\Livewire\SessionReport;

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
    });

    Route::group(['prefix' => 'session-report'], function () {
        Route::get('/{promptuary_id}', SessionReport\Index::class)->name('session-report.index');
    });

    Route::get('/backups', \App\Livewire\Backup\BackupManager::class)->name('backups.index');
    Route::get('/backup/download/{filename}', function ($filename) {
        $backupPath = storage_path('backups/' . $filename);

        if (!file_exists($backupPath)) {
            abort(404);
        }

        return response()->download($backupPath, $filename);
    })->name('backup.download');

});

require __DIR__ . '/auth.php';
