<?php
namespace App\Transformers\Users;

/**
 * Created by PhpStorm.
 * User: atul
 * Date: 5/9/2016
 * Time: 11:41 PM
 */

use League\Fractal\TransformerAbstract;
use App\Models\User;

use App\Transformers\Image\ImageTransformer;
use App\Transformers\People\PeopleTransformer;

class UserTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'image',
        'people',
     //   'personalcontactnumber',
        //'phones'
    ];

    public function transform(User $user)
    {
        // Specify what elements are going to be visible to the API
        return [
            'id' => (int) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'login_detail' => (string) $user->login_detail,
            'last_seen' => (boolean) $user->last_seen,
            'social_link' => (boolean) $user->social_link,
            'address' => (string) $user->address,
            'phone' => (string) $user->phone,
            'wishberry_awareness' => (string) $user->wishberry_awareness,
            'created_at' => (string) $user->created_at,
            'updated_at' => (string) $user->updated_at,
        ];
    }

    public function includeImage(User $user)
    {
        $image=null;
        if($user->image) {
            $image = $user->image;

            return $this->item($image, new ImageTransformer());
        }
    }

    public function includePeople(User $user)
    {
        $person=$user->people;
        return $this->item($person, new PeopleTransformer);
    }
}