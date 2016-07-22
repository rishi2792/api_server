<?php
/**
 * Created by PhpStorm.
 * User: ATUL
 * Date: 3/19/2016
 * Time: 6:12 PM
 */

namespace App\Repositories\User;



interface UserRepositoryInterface
{
   // public function getAll();

    public function find($userId);
}