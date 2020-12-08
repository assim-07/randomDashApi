<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class searchResource extends JsonResource
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
          'id'=>$this->content_id,
          'type'=>($this->is_series==0)?'movie':'series',
          'isSeries'=>$this->is_series,
          'link'=>($this->is_series==0)?asset('api/v1/movie/'.$this->content_id):asset('api/v1/series/'.$this->content_id),
          'attributes'=>[
             'name'=>$this->name,
             'type'=>$this->type,
             'likes'=>$this->likes,
             'view'=>$this->views,
             'dislikes'=>$this->dislikes,
             'language'=>$this->language,
             'year'=>$this->first_aired,
             'type'=>$this->type,
             'poster'=>['low'=>$this->images->poster_low!=null?'http://192.168.43.134:8000/'.$this->images->poster_low:null,
                        'medium'=>$this->images->poster_medium!=null?'http://192.168.43.134:8000/'.$this->images->poster_medium:null,
                        'large'=>$this->images->poster_large!=null?'http://192.168.43.134:8000/'.$this->images->poster_large:null,

         ],
          
          ]

        ];
    }
}
