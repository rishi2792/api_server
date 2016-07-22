<?php
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/12/2016
 * Time: 3:12 PM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

 class UserSignUpRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique|max:255',
            'email' => 'required',
        ];
    }


}