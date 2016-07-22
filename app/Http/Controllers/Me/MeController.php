<?php

namespace App\Http\Controllers\Me;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Input;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use App\Repositories\User\UserRepositoryInterface;
use App\Transformers\Users\UserTransformer;

class MeController extends BaseController
{
    protected $userRepository;

    protected $userTransformer;

    public function __construct(Request $request,UserRepositoryInterface $userRepository,UserTransformer $userTransformer)
    {
        parent::__construct($request);
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
    }

    public function index()
    {
        try
        {
            $userId=Authorizer::getResourceOwnerId();
            $user=$this->userRepository->find($userId);
            return $this->response->item($user, $this->userTransformer);
        }
        catch(\Exception $ex)
        {
            return $this->response->error(''.$ex->getMessage(), 500);
            //   return $this->response->error('Casinos Records Can Not Be Retrieve At This Moment !', 500);
        }
    }
}
