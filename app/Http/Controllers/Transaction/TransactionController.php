<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\BaseController;

use App\Repositories\Transaction\TransactionRepository\TransactionRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
class TransactionController extends BaseController
{
    
    
    
    public function __construct(Request $request,UserRepositoryInterface $userRepositoryInterface)
    {
        parent::__construct($request);
       // $this->transactionRepositoryInterface=$transactionRepositoryInterface;
        $this->userRepositoryInterface=$userRepositoryInterface;
    }



    public  function getSubmissionRules(){
       return[
        'country'=>'required|string',
         'pin'=>'required|integer',
           'address'=>'required|string',
           'city'=>'required|string',
           'state'=>'required|string',
           'phone'=>'required|integer',
           'anonymous'=>'required|boolean',
           'wishberry_awareness'=>'required|string'
        ];


    }
    public function submit($campaign_id,$reward_id){

        try {

            $input = Input::all();
            $user_id = \Authorizer::getResourceOwnerId();
           $validationRules = $this->getSubmissionRules();
           //\ $this->validateOrFail($input, $validationRules);
            return $transaction = $this->userRepositoryInterface->addinfo($user_id, $campaign_id, $reward_id, $input);
        }
        catch (ModelNotFoundException $e){

            return $this->response->errorNotFound('transaction not found');
        }
    }
    
}
