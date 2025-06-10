<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\PositionRepositoryInterface;
use App\Repositories\PositionRepository;

class PositionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PositionRepositoryInterface::class,PositionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
