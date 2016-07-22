<?php

namespace App\Http\Controllers\Me\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Response;
use Socialite;
use Illuminate\Support\Facades\Config;

class SocialAccountController extends BaseController
{

    public function redirectToProvider($provider,Request $request)
    {

        try
        {
            $request->session()->set('ui_redirect_url',''.$request->input('redirect'));
            return Socialite::driver($provider)->redirect();
        }
        catch(\Exception $ex)
        {
            \Log::debug("Exception With Social Redirecting = ".$ex->getMessage());
        }

    }

    public function handleProviderCallback($provider,Request $request)
    {
        $ui_redirect=$request->session()->pull('ui_redirect_url');

        switch ($provider) {
            case 'facebook':
                Config::set('services.facebook.redirect', env('SOCIAL_FACEBOOK_LINK_REDIRECT_URL'));
                break;
            /*case 'twitter':
                Config::set('services.twitter.redirect', env('SOCIAL_TWITTER_LINK_REDIRECT_URL'));
                break;
            case 'google':
                Config::set('services.google.redirect', env('SOCIAL_GOOGLE_LINK_REDIRECT_URL'));
                break;
            case 'instagram':
                Config::set('services.instagram.redirect', env('SOCIAL_INSTAGRAM_LINK_REDIRECT_URL'));
                break;*/
            default:
                throw new \Exception('Unknown social service: ' . $provider);
        }

        try
        {
            $social = Socialite::with($provider);
            $user = $social->user();

            return redirect()->away($ui_redirect.'?social_token='.$user.'&social_service='.$provider);

        }
        catch(\Exception $ex)
        {
            \Log::debug("Exception With Social Linking = ".$ex->getMessage());
        }
    }
}
