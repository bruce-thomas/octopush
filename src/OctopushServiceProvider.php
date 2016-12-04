<?php

namespace NotificationChannels\Octopush;

use Illuminate\Support\ServiceProvider;

class OctopushServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application service.
     */
    public function boot()
    {
        $this->app->when(OctopushChannel::class)
                    ->needs(OctopushClient::class)
                    ->give(function () {
                        $config = config('services.octopush');

                        return (new OctopushClient($config));
                    });
    }
}
