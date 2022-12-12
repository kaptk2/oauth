<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Spatie\Multitenancy\Http\Middleware\EnsureValidTenantSession;
use Spatie\Multitenancy\Http\Middleware\NeedsTenant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::withoutMiddleware([NeedsTenant::class, EnsureValidTenantSession::class])->group(function () {
    // Socalite Routes
    Route::get('/redirect/{service}', [LoginController::class, 'redirectToProvider'])->name('oauth.redirect');

    Route::get('/callback/{service}', [LoginController::class, 'handleProviderCallback']);
});
