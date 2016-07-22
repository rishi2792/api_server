<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    protected $table="transactions";

     protected  $fillable=['reward_id','user_id','campaign_id'];


    public function campaigns(){
        return $this->belongsTo('App\Models\campaign','campaign_id');
    }


    public function successcampaigns(){
        return $this->belongsToMany('App\Models\campaign','campaign_success_transaction','transaction_id','campaign_id')->withPivot('amount', 'is_refunded')->withTimestamps();
    }

    public function reward(){
        return $this->belongsTo('App\Models\rewards','reward_id');
    }

    public function user(){

        return $this->belongsTo('App\Models\Users','user_id');
    }





    
}
