<?php namespace App\Transformers\Image;

/**
 * Created by PhpStorm.
 * User: atul
 * Date: 5/4/2016
 * Time: 11:59 AM
 */
use League\Fractal\TransformerAbstract;
use App\Models\Image\Image;
use Request;

class ImageTransformer extends TransformerAbstract
{

    public function transform(Image $image)
    {
        // Specify what elements are going to be visible to the API
        $server="".Request::getUri();
        $server=substr($server,0,(strpos($server,"api/v1")-1));
        return [
            'image_url' => "". $server ."/api/v1/image/".$image->type."/".$image->id
        ];
    }
}