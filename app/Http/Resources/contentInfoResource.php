<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\series_episode;
use App\Http\Resources\seasonResource;
use App\Http\Resources\downloadResource;
use App\Models\movie_downloads;
use DB;

class contentInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $data= series_episode::select(['series_id','season_id'])->where('series_id',$this->content_id)->groupBy('season_id')->get();
        // return parent::toArray($request);
        return
        [
          'id'=>$this->content_id,
          'type'=>($this->is_series==0)?'movie':'series',
          'isSeries'=>$this->is_series,
          'link'=>($this->is_series==1)?'/api/v1/series/'.$this->content_id:'/api/v1/movie/'.$this->content_id,
          'attributes'=>[
             'name'=>$this->name,
             'type'=>$this->content_type,
             'description'=>$this->description,
             'status'=>$this->status,
             'length'=>$this->content_length,
             'contentType'=>$this->content_type,
             'episodeCount'=>$this->episode_count,
             'trailer'=>$this->trailer,
             'view'=>$this->views,
              'likes'=>$this->likes,
             'dislikes'=>$this->dislikes,
             'language'=>$this->language,
             'year'=>$this->first_aired,
             'type'=>$this->type,
             'poster'=>['low'=>$this->images->poster_low!=null?$this->images->poster_low:null,
                        'medium'=>$this->images->poster_medium!=null?$this->images->poster_medium:null,
                        'large'=>$this->images->poster_large!=null?$this->images->poster_large:null,
              ],
              'cover'=>['low'=>$this->images->cover_low!=null?$this->images->cover_low:null,
                        'medium'=>$this->images->cover_medium!=null?$this->images->cover_medium:null,
                        'large'=>$this->images->cover_large!=null?$this->images->cover_large:null,
              ],



        ],
        'relations'=>[
                'epiodes'=>($this->is_series==1)?asset('api/v1/series/'.$this->content_id.'/episodes/all'):null,
                'season'=>($this->is_series==1)?seasonResource::collection($data):[],
                'downloadlinks'=>($this->is_series==1)?[]: downloadResource::collection(movie_downloads::where('movie_id',$this->content_id)->get()),   


            ],
    ];
    }
}
