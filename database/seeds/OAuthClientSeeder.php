<?php namespace seeds;

use Illuminate\Database\Seeder;
use App\Models\OAuth\OAuthClient;
use App\Models\OAuth\OAuthClientScope;
use DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: ATUL
 * Date: 3/19/2016
 * Time: 7:22 PM
 */
class OAuthClientSeeder extends Seeder
{

    public function run()
    {
        $oauth_client_scope_arr = [
//            [
//                "client_name"=> 'app',
//                "scopes"=>[
//                    [
//                        "name"=>'remote',
//                    ],
//                    [
//                        "name"=>'proxy',
//                    ]
//                ]
//            ],
            [
                "client_name"=> 'manager',
                "scopes"=>[
                    [
                        "name"=>'admin',
                    ]
                ]
            ],
        ];

        $faker = Faker::create();

        // Seed OAuth Client And Client Scope
        foreach ($oauth_client_scope_arr as $oauth_client) {
            $exists = DB::table('oauth_clients')->where([
                'name' => $oauth_client["client_name"],
            ])->first();
            if (!$exists) {

                $clientId=env('CLIENT_ID');

                RECHECK_CLIENT:
                if(OAuthClient::where('id', '=', $clientId)->exists())
                {
                    $clientId=env('CLIENT_ID');
                    goto RECHECK_CLIENT;
                }
                else
                {
                    $clientSecret=env('CLIENT_SECRET');

                    RECHECK_SECRET:
                    if(OAuthClient::where('secret', '=', $clientSecret)->exists())
                    {
                        $clientSecret=$this->generatePin(32);
                        goto RECHECK_SECRET;
                    }

                    $oauthClient=OAuthClient::create([
                        'id' => $clientId,
                        'name' => $oauth_client["client_name"],
                        'secret' => $clientSecret,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    //\Log::debug("Client = ".json_encode($oauthClient));

                    // Seed Client Scope

                    foreach ($oauth_client["scopes"] as $oauth_client_scope) {
                        if(!(OAuthClientScope::where('id', '=', $oauth_client_scope["name"])->exists()))
                        {
                            //$scopeId=$this->generatePin(16);

                            /*RECHECK_SCOPE:
                            if(OAuthClientScope::where('id', '=', $scopeId)->exists())
                            {
                                $scopeId=$this->generatePin(16);
                                goto RECHECK_SCOPE;
                            }*/
                            $oauthClientScope=OAuthClientScope::create([
                                'id' => $oauth_client_scope["name"],
                                'description' => $oauth_client_scope["name"],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);

                            // Seed Client Id And Scope Id in bridge table
                            DB::table('oauth_client_scopes')->insert([
                                'client_id' => $clientId,
                                'scope_id' => $oauth_client_scope["name"],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function generatePin( $number ) {
        // Generate set of alpha characters
        $alpha = array();
        for ($u = 65; $u <= 90; $u++) {
            // Uppercase Char
            array_push($alpha, chr($u));
        }

        // Just in case you need lower case
         for ($l = 97; $l <= 122; $l++) {
            // Lowercase Char
            array_push($alpha, chr($l));
         }

        // Get random alpha character
        $rand_alpha_key = array_rand($alpha);
        $rand_alpha = $alpha[$rand_alpha_key];

        // Add the other missing integers
        $rand = array($rand_alpha);
        for ($c = 0; $c < $number - 1; $c++) {
            array_push($rand, mt_rand(0, 9));
            shuffle($rand);
        }

        return implode('', $rand);
    }
}