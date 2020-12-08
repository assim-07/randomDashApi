<?php

namespace App\Http\Resources;
use Illuminate\Http\Request;
 use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class genre extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       return[
         'id'=>$this->genre_id,
         'type'=>'genre',
         'attributes'=>[
           'genreName'=>$this->genre_name,
           'genreSlug'=>$this->genre_slug,

         ],
    

       ];
        // return parent::toArray($request);
        // with();
    }

    public function with($request)
    {
       return[
        'version'=>'1.2.'];
    }
}
