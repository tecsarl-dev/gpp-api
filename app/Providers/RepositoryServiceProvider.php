<?php

namespace App\Providers;

use App\Gpp\Capacities\Repositories\CapacityRepository;
use App\Gpp\Capacities\Repositories\Interfaces\CapacityRepositoryInterface;
use App\Gpp\Companies\Repositories\CompanyRepository;
use App\Gpp\Companies\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Gpp\Deliveries\Repositories\DeliveryRepository;
use App\Gpp\Depots\Repositories\DepotRepository;
use App\Gpp\Depots\Repositories\Interfaces\DepotRepositoryInterface;
use App\Gpp\LoadingSlips\Repositories\LoadingSlipRepository;
use App\Gpp\ProductLists\Repositories\Interfaces\ProductListRepositoryInterface;
use App\Gpp\ProductLists\Repositories\ProductListRepository;
use App\Gpp\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Gpp\Products\Repositories\ProductRepository;
use App\Gpp\Rates\Repositories\Interfaces\RateRepositoryInterface;
use App\Gpp\Rates\Repositories\RateRepository;
use App\Gpp\Responsibles\Repositories\Interfaces\ResponsibleRepositoryInterface;
use App\Gpp\Responsibles\Repositories\ResponsibleRepository;
use App\Gpp\Stations\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Gpp\Stations\Repositories\Interfaces\LoadingSlipRepositoryInterface;
use App\Gpp\Stations\Repositories\Interfaces\StationRepositoryInterface;
use App\Gpp\Stations\Repositories\StationRepository;
use App\Gpp\Trucks\Repositories\Interfaces\TruckRepositoryInterface;
use App\Gpp\Trucks\Repositories\TruckRepository;
use App\Gpp\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Gpp\Users\Repositories\UserRepository;
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
        $this->app->bind(
            CompanyRepositoryInterface::class,
            CompanyRepository::class,
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
        );

        $this->app->bind(
            StationRepositoryInterface::class,
            StationRepository::class,
        );

        $this->app->bind(
            LoadingSlipRepositoryInterface::class,
            LoadingSlipRepository::class,
        );

        $this->app->bind(
            DeliveryRepositoryInterface::class,
            DeliveryRepository::class,
        );

        $this->app->bind(
            CapacityRepositoryInterface::class,
            CapacityRepository::class,
        );

        $this->app->bind(
            ResponsibleRepositoryInterface::class,
            ResponsibleRepository::class,
        );

        $this->app->bind(
            TruckRepositoryInterface::class,
            TruckRepository::class,
        );

        $this->app->bind(
            DepotRepositoryInterface::class,
            DepotRepository::class,
        );

        $this->app->bind(
            RateRepositoryInterface::class,
            RateRepository::class,
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class,
        );

        $this->app->bind(
            ProductListRepositoryInterface::class,
            ProductListRepository::class,
        );

    }

}
