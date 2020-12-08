<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class episodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
          return
        [
          'episodesId'=>$this->id,
           'type'=>'episodes',
          'seriesId'=>$this->series_id,
          'link'=>asset('/api/v1/series/'.$this->series_id.'/episodes/'.$this->id),
         
          'attributes'=>[
             'episodeName'=>$this->episode_title,
              'episodeNumber'=>$this->episode_number,
             'poster'=>['low'=>null,
                        'medium'=>null,
                        'large'=>($this->poster_link!=null)?$this->poster_link:null,

         ],

          
          ]

        ];


   }
}
