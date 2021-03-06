<?php

namespace App\Models\Image;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'image';

    protected $fillable = ["imageable_id","imageable_type","type","mimeType","data"];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function data()
    {
        return $this->hasOne('App\Models\Image\ImageData', 'image_id');
    }
}
