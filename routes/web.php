<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\MemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController as UserBookController;



Route::get('/books/{book}', [UserBookController::class, 'show'])
    ->name('books.show');

Route::middleware('auth')->group(function () {

    Route::post('/books/{book}/borrow', [UserBookController::class, 'borrow'])
        ->name('books.borrow');

    Route::post('/books/{book}/reserve', [UserBookController::class, 'reserve'])
        ->name('books.reserve');

    Route::post('/books/{book}/return', [UserBookController::class, 'returnBook'])
        ->name('books.return');
});
Route::get('/profile', [ProfileController::class, 'index'])
    ->middleware('auth')
    ->name('profile');

Route::get('/', [HomeController::class, 'index'])
    ->name('home');
Route::get('/register', [RegisterController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisterController::class, 'store'])
    ->middleware('guest')
    ->name('register.store');


Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest')
    ->name('login.store');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

   
Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');
        Route::resource('books', BookController::class);

        Route::resource('members', MemberController::class);

        Route::get('/borrowings', [BorrowingController::class, 'index'])
            ->name('borrowings.index');

        Route::post('/borrowings', [BorrowingController::class, 'store'])
            ->name('borrowings.store');

        Route::post('/borrowings/{borrowing}/give-back', [BorrowingController::class, 'giveBack'])
            ->name('borrowings.giveBack');
    });