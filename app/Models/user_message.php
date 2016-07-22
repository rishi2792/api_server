<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_message extends Model
{
    protected  $table='user_message';

    public function campaign(){
        
        return $this->belongsTo('App\Models\campaign','campaign_id');
    }
}
