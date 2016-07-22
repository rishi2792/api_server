<?php
/**
 * Created by PhpStorm.
 * User: Heena M
 * Date: 7/19/2016
 * Time: 6:53 PM
 */

namespace App\Http\Controllers\Campaign;


use App\Http\Controllers\BaseController;
use App\Http\Requests\Campaign\CampaignCreateRequest;
use App\Models\campaign;
use App\Repositories\Campaign\CampaignRepositoryInterface;
use App\Transformers\Campaign\CampaignTransformer;
use App\Transformers\Campaign\PreviewCampaignTransformer;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
class CampaignController extends BaseController
{


    public function __construct(Request $request,CampaignRepositoryInterface $campaignRepositoryInterface ,CampaignTransformer $campaignTransformer,PreviewCampaignTransformer $previewCampaignTransformer){

        parent::__construct($request);
        $this->campaignRepositoryInterface=$campaignRepositoryInterface;
        $this->campaignTransformer=$campaignTransformer;
        $this->previewCampaignTransformer=$previewCampaignTransformer;

    }



    public function getCampaignCreateRules(){


        return [
            'name'=>'required',
            'description'=>'required'
        ];

    }

    public function getBudgetValidationRules(){


        return [
            'total_budget'=>'required|integer',
            'budget'=>'required',
            'days'=>'required'

        ];
    }

    public function getAddTeamRules(){


        return [
            'name'=>'required|string',
            'email'=>'required|email',
            'role'=>'required|string',
            'facebook_link'=>'required'
        ];

    }

    public function index(){


        $result_limit=Input::get('result_limit');
        $input=Input::all();
     //  return $cam=campaign::paginate($result_limit);

      $campaign=$this->campaignRepositoryInterface->get($result_limit,$input);

        if(isset($input['type'])) {
           // $campaign=$this->campaignRepositoryInterface->get($result_limit,$input);

                return $this->response->paginator($campaign, $this->previewCampaignTransformer);

        }

        return $this->response->paginator($campaign, $this->campaignTransformer);
    }


    public  function create(){


        $input=Input::all();
        $validationrules=$this->getCampaignCreateRules();
        $this->validateOrFail($input,$validationrules);


       // $social=explode(',');

        $campaign=$this->campaignRepositoryInterface->create($input);

        return $this->response->item($campaign,$this->campaignTransformer);

    }

    public function  addteam($campaign_id){

        $input=Input::all();
//        $validationrules=$this->getAddTeamRules();
//        $this->validateOrFail($input,$validationrules);
        
      return  $addpeople=$this->campaignRepositoryInterface->addteam($campaign_id,$input);
    //   return $this->response->item($addpeople,$this->campaignTransformer);
    }


    public function budget($campaign_id){


        $input=Input::all();

//        $validationrules=$this->getBudgetValidationRules();
//        $this->validateOrFail($input,$validationrules);

        $campaign=$this->campaignRepositoryInterface->budget($campaign_id,$input);
        return $this->response->item($campaign,$this->campaignTransformer);
    }



    public function wip($campaign_id){

        $input=Input::all();
        $campaign=$this->campaignRepositoryInterface->wip($campaign_id,$input);
        return $this->response->item($campaign,$this->campaignTransformer);


    }

}