<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rewards extends Model
{
   protected  $table = 'rewards';

    protected  $fillable=['name','descprition','amount','reward_count','limit','shipping_estimate_date','campaign_id'];

    public function transactions(){

        return $this->hasMany('App\Models\transaction','reward_id');
    }

    public function campaign(){
        return $this->belongsTo('App\Models\campaign','campaign_id');
    }

    public function image(){
        return $this->morphMany('App\Image\Image', 'imageable');
    }
}
