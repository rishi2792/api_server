<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\User\UserRepositoryInterface',
            'App\Repositories\User\UserRepository'
        );



        $this->app->bind(
            'App\Repositories\Campaign\CampaignRepositoryInterface',
            'App\Repositories\Campaign\CampaignRepository'
        );


        $this->app->bind(
            'App\Repositories\Campaign\RewardRepositoryInterface',
            'App\Repositories\Campaign\RewardRepository'
        );


        $this->app->bind(
            'App\Repositories\Transaction\TransactionRepositoryInterface',
            'App\Repositories\Transaction\TransactionRepository'
        );
    }
}
