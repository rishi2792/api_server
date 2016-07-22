<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class campaign extends Model
{

    protected $table = "campaign";

    protected $fillable = ['id', 'name', 'description', 'about', 'faq', 'days', 'budget', 'project_weblink', 'social_handle', 'status', 'comment', 'is_locked', 'is_active', 'live_date', 'total_budget', 'type_id'];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'campaigns_users', 'campaign_id', 'user_id')->withPivot('campaign_creator')->withTimestamps();

    }

    public function image()
    {
        return $this->morphMany('App\Models\Image\Image', 'imageable');

    }

    public function messages()
    {
        return $this->hasMany('App\Models\user_message', 'campaign_id');
    }


    public function transactions()
    {
        return $this->hasMany('App\Models\transaction', 'campaign_id');
    }

    public function stransactions()
    {
        return $this->belongsToMany('App\Models\transaction', 'campaign_success_transaction', 'campaign_id', 'transaction_id')->withPivot('amount')->withTimestamps();
    }

    public function type()
    {
        return $this->belongsToMany('App\Models\campaign_type', 'campaign_type_pivot', 'campaign_id', 'campaign_type_id');
    }


    public function rewards()
    {
        return $this->hasMany('App\Models\rewards', 'campaign_id');
    }

    public function creator()
    {
        return $this->belongsToMany('App\Models\User', 'campaigns_users', 'campaign_id', 'user_id')->where('campaign_creator',1)->withPivot('role');
    }

}
