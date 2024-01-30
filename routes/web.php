<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/clear', function() {
    Artisan::call('optimize:clear');
    return "Cache is cleared";
});

Route::get('/dbmigration', function() {
    Artisan::call(' migrate:fresh');
    return "DB migrated";
});

// Route::get('/', function () {
//     return redirect('/login');
// });

Route::get('/sendnotification', function() {
    Artisan::call('send:scheduled-notifications');
    return "Notifications have been send";
})->name('sendnotification');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'setTimezone'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('booking', BookingController::class);
});

require __DIR__.'/auth.php';
