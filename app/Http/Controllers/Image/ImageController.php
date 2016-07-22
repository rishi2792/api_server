<?php namespace App\Http\Controllers\Image;

/**
 * Created by PhpStorm.
 * User: atul
 * Date: 5/4/2016
 * Time: 12:09 PM
 */

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Input;

use App\Models\Image\Image;
use App\Models\Image\ImageData as Data;
use Illuminate\Support\Facades\Response;

class ImageController extends BaseController
{
    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function getImageByTypeAndId($type,$id)
    {
        try
        {
            $image_data=Image::find($id);
           // return $image_data;
            if(isset($image_data))
            {
                $image_file = Data::find($image_data->id);
                return Response::make($image_file->data, 200, array('Content-type' => $image_data->mime_type));
            }
            else
            {
                return Response::make(file_get_contents(storage_path() . '\app\public\No_image_available_full.svg.png'), 200, array('Content-type' => 'image/png'));
            }
        }
        catch (\Exception $ex)
        {
            return $this->response->error(''.$ex->getMessage(), 500);
        }
    }
}