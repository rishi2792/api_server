<?php namespace App\OAuth;

/**
 * Created by PhpStorm.
 * User: ATUL
 * Date: 3/19/2016
 * Time: 6:08 PM
 */

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordVerifier
{
    /**
     * Request object to be injected
     *
     * @var Request
     */
    public $request;

    protected $userRepository;

    public function __construct(Request $request, UserRepositoryInterface $userRepository)
    {
        $this->request = $request;
        $this->userRepository = $userRepository;
    }

    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        // Check for FB login
        if ($this->request->has('token_facebook')) {
            $user = $this->userRepo->createUser($this->request->all());

            return $user->id;
        }

        // For normal users
        if (Auth::once($credentials)) {
            \Log::debug("I am here PasswordVerifier");
            return Auth::user()->id;
        }

        return false;
    }
}