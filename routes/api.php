<?php

use Illuminate\Http\Request;
// use App\Http\Controllers\apiController;
use App\Http\Controllers\v1\ApiController;
use App\Http\Controllers\v1\seriesController;
use App\Http\Controllers\v1\movieController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () 
{


      Route::get('/latestMoviesAndSeries',[ApiController::class,'latestMoviesAndSeries']);
      Route::get('/featuredGenres',[ApiController::class,'featuredGenres']);
      Route::get('/slider',[ApiController::class,'slider']);
      Route::get('/latestMovies',[movieController::class,'latestMovies']);
      Route::get('/latestSeries',[seriesController::class,'latestSeries']);
      Route::get('/search',[ApiController::class,'search']);
      Route::get('/',[ApiController::class,'index']);
      Route::get('genre/all',[ApiController::class,'genreAll']);
      Route::get('genreFeatured',[ApiController::class,'genreFeatured']);
      
      Route::get('genre/{genreID}',[ApiController::class,'genre']);
 
      Route::get('movies/all',[movieController::class,'movieAll']);
      Route::get('movies/{movieID}',[movieController::class,'movie']);

      Route::get('series/all',[seriesController::class,'seriesAll']);
      Route::get('series/{seriesID}',[seriesController::class,'series']);
      
      Route::get('series/{seriesID}/episodes/all',[seriesController::class,'episodeAll']);
      Route::get('series/{seriesID}/episodes/{episodeID}',[seriesController::class,'episode']);
      Route::get('series/{seriesID}/season/seasonID',[seriesController::class,'episode']);
      Route::get('series/{seriesID}/season/{seasonID}',[seriesController::class,'season']);

 });

// Route::get('genre',[ApiController::class,'index']);

Route::fallback(function()
{
      return response()->json([
      'message'=>'failed',
      'status'=>400
    
      ],404);
});