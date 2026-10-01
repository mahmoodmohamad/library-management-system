<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController as UserBookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


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

        Route::post('members/applications/{application}/reject', [MemberController::class, 'rejectApplication'])
            ->name('members.applications.reject');

        Route::resource('members', MemberController::class);

        /*
        | Borrowings
        */
        Route::get('/borrowings', [BorrowingController::class, 'index'])
            ->name('borrowings.index');

        Route::post('/borrowings', [BorrowingController::class, 'store'])
            ->name('borrowings.store');

        Route::post('/borrowings/{borrowing}/give-back', [BorrowingController::class, 'giveBack'])
            ->name('borrowings.giveBack');
    });