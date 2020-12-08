<?php

namespace App\Http\Controllers\v1;


use App\Http\Resources\genre as genreResource;
// use App\Http\Resources\movieResource;
// use App\Http\Resources\movieInfoResource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Resources\contentResource;
 use App\Http\Resources\contentInfoResource;
use App\Models\series;
use App\Models\movie_downloads;


class movieController extends Controller
{

	 public function movieAll()
     {
        
         $data=series::with('images')->where('is_series',0)->where('published',1)->paginate(20);
          if($data->isNotEmpty())
          {
               return contentResource::collection($data)->additional(
                [
                    
                    'status'=>'200',
                    'message'=>'Success'
              ]);
         
          }
          return [
             'status'=>'400',
               'message'=>'Failed'
          ];
     
     }

     public function movie($movieID)
     {
     	// return 'hi';
        // $tempjson =array();
        $data=series::with('images')->where('is_series',0)->where('published',1)->findOrFail($movieID);
        // $data1=movie_downloads::all();
        // return $data;
        
        return (new contentInfoResource($data))->additional( [
                    
                    'status'=>'200',
                    'message'=>'Success'
            ]);
     }
    
 public function latestMovies()
    {
      $movies=series::where('published',1)->where('is_series',0)->latest()->limit(6)->get();

      if($movies->isNotEmpty())
      {
        return contentResource::collection($movies)->additional(
                [
                    
                    'status'=>'200',
                    'message'=>'Success'
              ]);

      }
      else
      {
        return response()->json([
          'message'=>'Failed',
          'status'=>404
        ]);
      }
      

    }










}
