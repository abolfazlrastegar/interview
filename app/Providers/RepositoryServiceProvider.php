<?php

namespace App\Providers;

use App\Repository\CoinInterface;
use App\Repository\FollowerInterface;
use App\Repository\OrderInterface;
use App\Repository\v1\RepositoryCoin;
use App\Repository\v1\RepositoryFollower;
use App\Repository\v1\RepositoryOrder;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OrderInterface::class, RepositoryOrder::class);
        $this->app->bind(FollowerInterface::class, RepositoryFollower::class);
        $this->app->bind(CoinInterface::class, RepositoryCoin::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
