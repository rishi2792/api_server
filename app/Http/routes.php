<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',['prefix' => 'api/v1'], function ($api) {
    $api->get('test', 'App\Http\Controllers\TestController@index');

    $api->post('login', 'App\Http\Controllers\OAuth\AuthController@login');
    $api->post('signup', 'App\Http\Controllers\OAuth\AuthController@signup');
    $api->post('login/social/{provider}', 'App\Http\Controllers\OAuth\AuthController@socialLogin');

    // Social Login Routes
    $api->get('social/login/redirect/{provider}', 'App\Http\Controllers\Me\Profile\SocialAccountController@redirectToProvider');
    $api->get('social/login/{provider}', 'App\Http\Controllers\Me\Profile\SocialAccountController@handleProviderCallback');
    $api->get('campaign','App\Http\Controllers\Campaign\CampaignController@index');
});





$api->version('v1', ['prefix' => 'api/v1','middleware' => 'api.auth','providers' => ['oauth'],'scopes' => ['admin']], function ($api) {
    $api->get('test3', 'App\Http\Controllers\TestController@test3');

    $api->post('campaign','App\Http\Controllers\Campaign\CampaignController@create');
    $api->post('campaign/{campaign_id}/people','App\Http\Controllers\Campaign\CampaignController@addteam');
    $api->post('campaign/{campaign_id}/budget','App\Http\Controllers\Campaign\CampaignController@budget');

    $api->post('campaign/{campaign_id}/wip','App\Http\Controllers\Campaign\CampaignController@wip');


    $api->post('campaign/{campaign_id}/projectinfo','App\Http\Controllers\Campaign\CampaignController@projectinfo');

    $api->post('campaign/{campaign_id}/rewards','App\Http\Controllers\Campaign\RewardController@create');
    $api->post('transaction/{campaign_id}/reward/{reward_id}/initiate','App\Http\Controllers\Transaction\TransactionController@initiate');
  
    $api->post('transaction/{campaign_id}/reward/{reward_id}/submit','App\Http\Controllers\Transaction\TransactionController@submit');






});

