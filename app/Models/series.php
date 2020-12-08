<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\series_poster;
use App\Models\rel;


class series extends Model
{
    use HasFactory;
 protected $primaryKey='content_id';

   public function images()
    {
    	return $this->hasOne(series_poster::class,'content_id','content_id');
    }
    // public function rel()
    // {
    // 	return $this->hasOne(pivot::class,'content_id','content_id');
    // }
}
