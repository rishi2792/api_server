<?php

namespace App\Http\Controllers\OAuth;

use Authorizer;
use League\OAuth2\Server\Exception\InvalidCredentialsException;
use Mockery\CountValidator\Exception;
use Validator;
use Config;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Mail\Message;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Password;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\Social\SocialAccountNotLinkedException;

use App\Models\OAuth\OAuthClient;
use App\Models\User\Social;

use Illuminate\Support\Facades\Input;

class AuthController extends BaseController
{

    /**
     * To get common validation rules for login and fblogin
     *
     * @return array
     */
    public function getLoginValidationRules()
    {
        return [
            'grant_type' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required',
            'username' => 'required|email',
            'password' => 'required',
            'scope' => 'required',
        ];
    }

    public function getSocialLoginValidationRules()
    {
        return [
            'grant_type' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required',
            'social_service_id' => 'required',
            'social_service' => 'required',
            'scope' => 'required',
        ];
    }

    public function getSocialLoginBasicValidationRules()
    {
        return [
            'email' => 'required',
            'social_service' => 'required',
            'social_service_id' => 'required',
        ];
    }

    public function getSignUpValidationRules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique',
            'password' => 'required',
        ];
    }

    /**
     * Verify user credentials and generates authentication token
     *
     * @Get("/login")
     * @Versions({"v1"})
     *
     * @Request({"grant_type":"password", "client_id":"{{client_id}}", "client_secret":"{{client_secret}}", "username":"fake@fake.com", "password":"secret"})
     *
     * @Response(200, body={"access_token":"{{generated_token}}","token_type":"Bearer","expires_in":86400})
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $userScope = "admin";

        Input::merge([
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'scope' => $userScope
        ]);

        $credentials = $request->only(['grant_type', 'client_id', 'client_secret', 'username', 'password', 'scope']);


        $validationRules = $this->getLoginValidationRules();

        $credentials["client_id"] = env('CLIENT_ID');
        $credentials["client_secret"] = env('CLIENT_SECRET');


        // return $validationRules;


        $this->validateOrFail($credentials, $validationRules);

        try {
            if (!$accessToken = Authorizer::issueAccessToken()) {
                return $this->response->errorUnauthorized();
            }
        } catch (\League\OAuth2\Server\Exception\OAuthException $e) {
            throw $e;
            return $this->response->error('could_not_create_token', 500);
        }

        $accessToken["groups"][] = $userScope;
        return response()->json(compact('accessToken'));
    }

    public function socialLogin(Request $request, $provider)
    {
        try {
            $credentials = $request->only(['email', 'social_service', 'social_service_id']);
            $validationRules = $this->getSocialLoginBasicValidationRules();
            $this->socialValidateOrFail($credentials, $validationRules);


            $user = $this->getUserIdByEmail($request->get('email'));
            $social = $this->getSocialAccountByUserIDAndSocialServiceId($user->id, $request->get('social_service_id'), $provider);
            //return $social;
            $socialOAuthToken = $this->getSocialOAuthToken($request->get('social_service_id'), $provider, $user);
            return response()->json(compact('socialOAuthToken'));
        } catch (SocialAccountNotLinkedException $sanlex) {
            //social account not linked yet catched
            //add entry for social service id in user_social_medias table
            $social = $this->setSocialAccount($user->id, $request->get('social_service_id'), $provider);
            $socialOAuthToken = $this->getSocialOAuthToken($request->get('social_service_id'), $provider, $user);
            return response()->json(compact('socialOAuthToken'));
        }
    }

    public function getSocialOAuthToken($socialServiceId, $provider, $user)
    {
        try {

            $clientData = \DB::table('oauth_clients')->where('name', 'app')->first();

            $userScope = $this->checkUserScope($user->email);

            Input::merge([
                'client_id' => "" . $clientData->id,
                'client_secret' => "" . $clientData->secret,
                'grant_type' => "social",
                'scope' => $userScope
            ]);

            $credentials["client_id"] = "" . $clientData->id;
            $credentials["client_secret"] = "" . $clientData->secret;
            $credentials["grant_type"] = "social";
            $credentials["social_service_id"] = $socialServiceId;
            $credentials["social_service"] = $provider;

            try {
                if (!$accessToken = Authorizer::issueAccessToken()) {
                    return $this->response->errorUnauthorized();
                }
            } catch (\League\OAuth2\Server\Exception\OAuthException $e) {
                throw $e;
                return $this->response->error('could_not_create_token', 500);
            }

            $accessToken["groups"][] = $userScope;
            return $accessToken;


        } catch (\Exception $ex) {
            return $this->response->error($ex->getMessage(), 500);
        }
    }

    public function setSocialAccount($userId, $socialServiceId, $provider)
    {
        try {
            $social = \DB::table('user_social_medias')->insert([
                "user_id" => $userId,
                "social_service" => $provider,
                "social_service_id" => $socialServiceId
            ]);
            return $social;
        } catch (\Exception $ex) {
            return $this->response->error($ex->getMessage(), 500);
        }
    }

    public function getSocialAccountByUserIDAndSocialServiceId($userId, $socialServiceId, $provider)
    {
        try {
            $social = Social::where('user_id', $userId)
                ->where('social_service_id', $socialServiceId)
                ->where('social_service', $provider)->firstOrFail();
            return $social;
        } catch (ModelNotFoundException $mnfex) {
            throw new SocialAccountNotLinkedException;
            //return $this->response->error('Social Service Is Not Linked Yet !', 404);
        } catch (\Exception $ex) {
            return $this->response->error('Error Occurred !', 500);
        }
    }

    public function getUserIdByEmail($email)
    {
        try {
            $user = User::where('email', $email)->firstOrFail();
            return $user;
        } catch (ModelNotFoundException $mnfex) {
            return $this->response->error('User Does Not Exists !', 404);
        } catch (\Exception $ex) {
            return $this->response->error('Error Occurred !', 500);
        }
    }

    public function checkUserScope($email)
    {
        try {
            if ((User::where('email', '=', $email)->exists())) {
                $userId = User::where('email', '=', $email)->pluck('id');
                $user = User::find($userId);
                $groups = $user->groups;
                return $groups[0]->name;
            } else {
                return "empty";
            }
        } catch (\Exception $ex) {
            return $this->response->error('Error Occurred : ' . $ex->getMessage(), 404);
        }
    }


    public function signup()
    {

        // $validationRules = $this->getSignUpValidationRules();

        DB::beginTransaction();
        $input = Input::all();
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password'])
        ]);
        $userScope = "admin";


        $input = [
            'grant_type' => 'password',
            'username' => 'sample11@demo.com',
            'password' => $input['password'],
            'scope' => $userScope,
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
        ];


        $credentials = $input;//$request->only(['grant_type', 'client_id', 'client_secret', 'username', 'password','scope']);

        $validationRules = $this->getLoginValidationRules();


        $credentials["client_id"] = env('CLIENT_ID');
        $credentials["client_secret"] = env('CLIENT_SECRET');

        $this->validateOrFail($credentials, $validationRules);

        try {
            if (!$accessToken = Authorizer::issueAccessToken()) {
                return $this->response->errorUnauthorized();
            }
        } catch (\League\OAuth2\Server\Exception\OAuthException $e) {
            throw $e;
            return $this->response->error('could_not_create_token', 500);
        }
        DB::commit();

        $accessToken["groups"][] = $userScope;

        return response()->json(compact('accessToken'));


    }
}
