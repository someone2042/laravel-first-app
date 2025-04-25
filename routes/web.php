<?php

use App\Models\Listing;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

Route::get('/', [ListingController::class, 'index']);

Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

Route::get('listings/manage', [ListingController::class, 'manage'])->middleware('auth');

Route::get('/register', [UserController::class, 'create'])->middleware('guest');

Route::post('/users', [UserController::class, 'store']);

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

Route::post('/users/authenticate', [UserController::class, 'authenticate']);




Route::get('/listings/{listing}', [ListingController::class, 'show']);
// Route::get('/hello', function(){
//     return response('hello',200)
//     ->header('content-type','text/plain')
//     ->header('foo','bar');
// });
// Route::get('/post/{id}',function($id){
//     ddd($id);
//     return response('post'. $id); 

// })->where( 'id' ,'[0-9]+');
// Route::get('/search',function(Request $request){
//     dd($request);
// });
