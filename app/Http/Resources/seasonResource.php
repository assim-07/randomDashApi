<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class seasonResource extends JsonResource
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
        'seasonId'=>$this->season_id,
        'seasonName'=>"season ".$this->season_id,
        'link'=>asset('api/v1/series/'.$this->series_id.'/season/'.$this->season_id),
        // 'seasonLink'=>asset('api')
       ];
    }
}
