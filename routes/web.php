<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController as UserBookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


use App\Http\Controllers\Admin\StaffController;
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn () => view('auth.verify-email'))->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $r) {
        $r->fulfill();
        return redirect()->route('profile');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $r) {
        $r->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent.');
    })->middleware('throttle:6,1')->name('verification.send');
});

// routes/web.php
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'email'])->middleware('throttle:6,1')->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/books', [UserBookController::class, 'index'])
    ->name('books.index');

Route::get('/books/{book}', [UserBookController::class, 'show'])
    ->name('books.show');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register.store');

    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::get('/membership/apply', [MembershipApplicationController::class, 'create'])
        ->name('membership.apply');

    Route::post('/membership/apply', [MembershipApplicationController::class, 'store'])
        ->name('membership.apply.store');

    Route::post('/books/{book}/borrow', [UserBookController::class, 'borrow'])
        ->name('books.borrow');

    Route::post('/books/{book}/reserve', [UserBookController::class, 'reserve'])
        ->name('books.reserve');

    Route::delete('/books/{book}/reserve', [UserBookController::class, 'cancelReservation'])
        ->name('books.reserve.cancel');

    Route::post('/books/{book}/return', [UserBookController::class, 'returnBook'])
        ->name('books.return');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
Route::resource('staff', StaffController::class)->except('show');



Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        | Books
        */
        Route::resource('books', BookController::class);

        /*
        | Members
        */
        Route::get('members/pending', [MemberController::class, 'pending'])
            ->name('members.pending');

        Route::post(
            'members/applications/{application}/reject',
            [MemberController::class, 'rejectApplication']
        )->name('members.applications.reject');

        Route::resource('members', MemberController::class);

        /*
        | Borrowings
        */
        Route::get('/borrowings', [BorrowingController::class, 'index'])
            ->name('borrowings.index');

        Route::post('/borrowings', [BorrowingController::class, 'store'])
            ->name('borrowings.store');

        Route::post(
            '/borrowings/{borrowing}/give-back',
            [BorrowingController::class, 'giveBack']
        )->name('borrowings.giveBack');
    });