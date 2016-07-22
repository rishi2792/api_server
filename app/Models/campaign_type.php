<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class campaign_type extends Model
{
    protected $table= 'campaign_type';

    public function campaigns(){
        return $this->belongsToMany('App\Models\campaign','campaign_type_pivot','campaign_type_id','campaign_id');

    }
}
