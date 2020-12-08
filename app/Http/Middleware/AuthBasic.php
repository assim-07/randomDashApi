<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\movies;
use Illuminate\Http\Response;
use DB;

class AuthBasic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
          return $next($request);
        // $token =$request->header('AppKey');
        // if($token==config('services.AnimeApi.Key'))
        // {
        //     return $next($request);
        // }
        // else
        // {
        //    // $data=movies::select('movie_id')->where('movie_id',1)->get();
        //     // return DB::table('genres')->get();
        //     return response()->json(['status'=>401,'message'=>'faisled'],401);
        // }

       
    }
}
