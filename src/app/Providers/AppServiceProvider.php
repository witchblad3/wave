<?php

namespace App\Providers;

use App\Repositories\Read\Room\RoomReadRepository;
use App\Repositories\Read\Room\RoomReadRepositoryInterface;
use App\Repositories\Write\Room\RoomWriteRepository;
use App\Repositories\Write\Room\RoomWriteRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RoomReadRepositoryInterface::class, RoomReadRepository::class);
        $this->app->bind(RoomWriteRepositoryInterface::class, RoomWriteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
