<?php

use App\Http\Controllers\AdminVideoController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SingingController;
use App\Http\Controllers\UserDetailController;
use App\Http\Controllers\VideoController;
use App\Models\Payment;
use App\Models\Singing;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', function() { return view('welcome');})->name('home');
Route::group(['middleware' => ['auth', 'verified']], function () {
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



    Route::get('/payment/{plan?}', [PaymentController::class, 'charge'])->name('goToPayment');
    Route::post('payment/process-payment/{plan?}', [PaymentController::class, 'processPayment'])->name('processPayment');

    Route::middleware('isPaid')->group(function () {
        Route::resource('user-details', UserDetailController::class);
        Route::resource('singing', SingingController::class);
        Route::get('/upload-video/{plan?}', [VideoController::class, 'index'])->name('upload-video');
        Route::post('/upload-video', [VideoController::class, 'upload'])->name('video.upload');
        Route::get('/thank-you', function () {
            return view('thanks');
        })->name('thank-you');
    });
});


// ========== Admin ================
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/videos', [AdminVideoController::class, 'index'])->name('admin.videos.index');
    Route::put('/admin/videos/{video}/status', [AdminVideoController::class, 'updateStatus'])->name('admin.videos.updateStatus');
    Route::get('/admin/videos/{video}', [AdminVideoController::class, 'show'])->name('admin.videos.show');

    Route::get('/admin/users/{user}', [AdminVideoController::class, 'user'])->name('admin.users.show');
});
