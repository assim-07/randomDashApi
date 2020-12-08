<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\downloadResource;
use App\Models\series_downloads;
class episodeInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
          return
        [
          'episodesId'=>$this->id,
          'seriesId'=>$this->series_id,
           'type'=>'episodes',
          'link'=>asset('/api/v1/series/'.$this->series_id.'/episodes/'.$this->id),
         
          'attributes'=>[
             'episodeName'=>$this->episode_title,
              'episodeDescription'=>$this->episode_description,
             'likes'=>$this->likes,
             'view'=>$this->views,
             'dislikes'=>$this->dislikes,
             'poster'=>['low'=>null,
                        'medium'=>null,
                        'large'=>'http://192.168.43.134:8000/'.$this->poster_link,


         
         ],
          'downloadLinks'=>downloadResource::collection(series_downloads::where('episode_id',$this->id)->get()),

          
          ]

        ];
    }
}
