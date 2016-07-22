<?php
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/12/2016
 * Time: 3:12 PM
 */

namespace App\Http\Requests\Campaign;

use App\Http\Requests\Request;

use App\Traits\Http\RequestsTrait;
class CampaignCreateRequest extends Request
{

    use RequestsTrait;
    public function rules()
    {
        return [
            'name' => 'required|unique|max:255',
            'description' => 'required',
        ];
    }


}