<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Gpp\Rates\Repositories\RateRepository;
use App\Gpp\Users\Repositories\UserRepository;
use App\Gpp\Cities\Repositories\CityRepository;
use App\Gpp\Depots\Repositories\DepotRepository;
use App\Gpp\Trucks\Repositories\TruckRepository;
use App\Gpp\Products\Repositories\ProductRepository;
use App\Gpp\Stations\Repositories\StationRepository;
use App\Gpp\Companies\Repositories\CompanyRepository;
use App\Gpp\Decisions\Repositories\DecisionRepository;
use App\Gpp\Capacities\Repositories\CapacityRepository;
use App\Gpp\Deliveries\Repositories\DeliveryRepository;
use App\Gpp\LoadingSlips\Repositories\LoadingSlipRepository;
use App\Gpp\ProductLists\Repositories\ProductListRepository;
use App\Gpp\Responsibles\Repositories\ResponsibleRepository;
use App\Gpp\Rates\Repositories\Interfaces\RateRepositoryInterface;
use App\Gpp\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Gpp\Cities\Repositories\Interfaces\CityRepositoryInterface;
use App\Gpp\Depots\Repositories\Interfaces\DepotRepositoryInterface;
use App\Gpp\Trucks\Repositories\Interfaces\TruckRepositoryInterface;
use App\Gpp\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Gpp\Stations\Repositories\Interfaces\StationRepositoryInterface;
use App\Gpp\Companies\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Gpp\Decisions\Repositories\Interfaces\DecisionRepositoryInterface;
use App\Gpp\Capacities\Repositories\Interfaces\CapacityRepositoryInterface;
use App\Gpp\Deliveries\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Gpp\LoadingSlips\Repositories\Interfaces\LoadingSlipRepositoryInterface;
use App\Gpp\ProductLists\Repositories\Interfaces\ProductListRepositoryInterface;
use App\Gpp\Responsibles\Repositories\Interfaces\ResponsibleRepositoryInterface;

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

        $this->app->bind(
            CityRepositoryInterface::class,
            CityRepository::class,
        );
        
        $this->app->bind(
            DecisionRepositoryInterface::class,
            DecisionRepository::class,
        );

    }

}
