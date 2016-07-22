<?php
/**
 * Created by PhpStorm.
 * User: ATUL
 * Date: 3/19/2016
 * Time: 6:13 PM
 */

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user=$user;
    }

    public function find($userId)
    {
        $user=$this->user->findOrFail($userId);
        return $user;
    }
}