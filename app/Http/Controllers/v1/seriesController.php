<?php

namespace App\Http\Controllers\v1;
use App\Http\Resources\seriesResource;
use App\Http\Resources\episodeResource;
use App\Http\Resources\episodeInfoResource;
use App\Http\Resources\contentInfoResource;
use App\Http\Resources\contentResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\series;
use App\Models\series_episode;
use DB;



class seriesController extends Controller
{
    
    public function latestSeries()
    {
      // return 'ji';
        $series=series::where('published',1)->where('is_series',1)->latest()->limit(6)->get();


        if($series->isNotEmpty())
      {
        return seriesResource::collection($series)->additional(
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




    public function seriesAll()
    {

    	 $data=series::with('images')->where('is_series',1)->where('published',1)->paginate(20);
         // return $data;

    	  if($data->isNotEmpty())
    	{
    		return contentResource::collection($data)->additional(
                [
                    
                    'status'=>'200',
                    'message'=>'Success'
            ]);
    	}

    	 return [
                    
                    'status'=>'301',
                    'message'=>'Failed'
            ];
    }


    public function series($seriesID)
    {
        // return $data= series_episode::select(['series_id','season_id'])->where('series_id',$seriesID)->groupBy('season_id')->get();
    	  $data=series::with('images')->where('published',1)->findOrFail($seriesID);
           return (new contentInfoResource($data))->additional( [
                    
                    'status'=>'200',
                    'message'=>'Success'
            ]);
    }






     public function episodeAll($seriesID)
    {

       // return 'hi';
    	$data=series_episode::where('series_id',$seriesID)->paginate(20);
      // return 'hi';
    	if($data->isEmpty())
    	{
    		return [
                    
                    'status'=>'301',
                    'message'=>'Failed'
            ];
    	}
      return episodeResource::collection($data)->additional(
                [
                    
                    'status'=>'200',
                    'message'=>'Success'
            ]);

    }


    public function episode($seriesID,$episodeID)
    {
    	$data=series_episode::where('series_id',$seriesID)->where('id',$episodeID)->firstorFail();
    	return (new episodeInfoResource($data))->additional(
                [
                    
                    'status'=>'200',
                    'message'=>'Success'
            ]);
    }



    public function season($seriesID,$seasonID)
    {
       $data=series_episode::where('series_id',$seriesID)->where('season_id',$seasonID)->get();

       if($data->isNotEmpty())
       {
       	return episodeResource::collection($data)->additional(
                [
                    
                    'status'=>'200',
                    'message'=>'Success'
            ]);;
       }

      return [
                    
                    'status'=>'301',
                    'message'=>'Failed'
            ]; 
    }
}
