<?php

namespace App\Http\Controllers\v1;

use App\Http\Resources\genre as genreResource;
// use App\Http\Resources\movieResource;
// use App\Http\Resources\movieInfoResource;
 use App\Http\Resources\seriesInfoResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pivot;
use DB;
use App\Http\Resources\seriesResource;
use App\Http\Resources\contentResource;
use App\Models\genres;
use App\Models\movies;
use App\Models\series;
use App\Models\movie_store_images;
use App\Models\movie_downloads;
use Illuminate\Support\Facades\Cache;
class ApiController extends Controller
{

  public function slider()
  {

  return Cache()->remember('sliderApi',60*60*24,function()
 {
        return response()->json(
       [
       'slider'=>DB::table('slider')->get(),
       'status'=>200,
       'message'=>'success'
       ]

        ); 
         });
  }

public function latestMoviesAndSeries()
{
   $movies=series::where('published',1)->where('is_series',0)->latest()->limit(6)->get();
   $series=series::where('published',1)->where('is_series',1)->latest()->limit(6)->get();

      if($movies->isNotEmpty() or $movies->isNotEmpty())
      {


        return response()->json([


          'data'=>[
        '0'=>[

              'category'=>'Latest Movies',
              'data'=>contentResource::collection($movies),

        ],
        '1'=>[

           'category'=>'Latest Series',
           'data'=>contentResource::collection($series)
        ]

      ],
      'message'=>'Success',
      'status'=>200


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


  public function featuredGenres()
 {
    Cache()->forget('featuredGenres');
      return Cache()->remember('featuredGenres',60*60*24,function()
        {

             $dynamicContent=array();
             $featuredGenre=genres::where('featured',1)->get();
                 foreach ($featuredGenre as $key => $value){

                   $comedy =series::with('images')->join('genre_pivots','series.content_id','=','genre_pivots.content_id')->where('genre_pivots.genre_slug',$value->genre_name)->where('is_series',1)->limit(6)->get();
                   $dynamicContent+=array(
                    $key=>[

                      'category'=>$value->genre_name,
                       'data'=>contentResource::collection($comedy),
                       'length'=>count($comedy),
                    ]

                   );
                 }
         return response()->json([
          'data'=>$dynamicContent,
          'status'=>200,
          'message'=>'success'
      

         ]

         );

        });
             
 }

    public function index()
    {


        Cache()->forget('indexApi');
      return Cache()->remember('indexApi',60*60*24,function()
        {

            

                 
                 $featuredMovies=series::where('featured',1)->where('is_series',0)->limit(6)->get();
               
                 $featuredSeries=series::where('featured',1)->where('is_series',1)->limit(6)->get();
                 $topViewedMovies=series::where('published',1)->where('is_series',0)->orderBy('views','desc')->limit(6)->get();
                 $topViewedSeries=series::where('published',1)->where('is_series',1)->orderBy('views','desc')->limit(10)->get();  
                 $randomSeries=series::where('published',1)->inRandomOrder()->limit(6)->get();
   
         return response()->json([
          'data'=>
          [
                '0'=>['category'=>'Featured Movies',
                       'data'=>contentResource::collection($featuredMovies),
                       'length'=>count($featuredMovies),], 
                 '1'=>['category'=>'Featured Series',
                       'data'=>contentResource::collection($featuredSeries),
                       'length'=>count($featuredSeries),],
                       
                 '2'=>['category'=>'Topviewed Movies',
                       'data'=>contentResource::collection($topViewedMovies),
                       'length'=>count($topViewedMovies),],  

                 '3'=>['category'=>'Topviewed Series',
                       'data'=>contentResource::collection($topViewedSeries),
                       'length'=>count($topViewedSeries),],
                 '4'=>['category'=>'Random Series',
                       'data'=>contentResource::collection($randomSeries),
                       'length'=>count($randomSeries),],
            
          ],
          'status'=>200,
          'message'=>'success'
      

         ]

         );

        });
             

  
        
    }




   


    public function search(Request $request)
    {
       if($request->has('id'))
       {
        $get =htmlspecialchars($request->get('id'));
        $get=stripslashes($get);
        $get=strip_tags($get);


        $users = series::with('images')
                    ->where('name', 'like', "%$get%")
                    ->get();
         return contentResource::collection($users);



       }
       else{
        return response()->json(
          [
          'status'=>400,
          'message'=>'failed'

          ]
        );
       }
    }

    
      


    public function genreAll()
    {

        $data =genres::all();      
    	// $data= DB::table('genres')->get()->map(function($item,$key){
    	// 	return (array)$item;
    	// })->all();
    // $data= DB::table('downloads')->get();
        if(count($data))
        {
           $count=DB::table('genres')->count();
            return genreResource::collection($data)->additional(
                [
                    'length'=>$count,
                    'status'=>'200',
                    'message'=>'Success'
            ]);
        }
        else
        {
            return [
               'status'=>'400',
               'message'=>'Failed'
            ];
        }
   
    }


    public function genre($genreID)
    {
     $data =genres::findOrFail($genreID);

     return (new genreResource($data))->additional(
                [          
                    'status'=>'200',
                    'message'=>'Success'
            ]);
   
    }


    public function genreFeatured()
    {
     $data =genres::where('featured',1)->get();
     $count= genres::where('featured',1)->count();
     // return $data;
     if($data->isEmpty())
     {
        return [
               'status'=>'404',
               'message'=>'Failed'
            ];  
     }
     return genreResource::collection($data)->additional(
                [
                    'length'=>$count,
                    'status'=>'200',
                    'message'=>'Success'
            ]);
    }
}
// php artisan make:model genres