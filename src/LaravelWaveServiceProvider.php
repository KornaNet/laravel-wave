<?php

namespace Qruto\LaravelWave;

use Qruto\LaravelWave\Commands\Ping;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelWaveServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-wave')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoute('web')
            ->hasMigration('create_laravel-wave_table')
            ->hasCommand(Ping::class);
    }

    public function registeringPackage()
    {
        $this->app->bind(ServerSentEventSubscriber::class, RedisSubscriber::class);
    }

    public function bootingPackage()
    {
        Event::listen(
            SseConnectionClosedEvent::class,
            [RemoveStoredConnectionListener::class, 'handle']
        );
    }
}