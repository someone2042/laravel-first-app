<?php

use App\Http\Controllers\ListingController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

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

Route::get('/', [ListingController::class,'index']);

Route::get('/listings/{listing}',[ListingController::class,'show']);

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
