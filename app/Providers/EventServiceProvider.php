<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Events\ContactScoreProcessed;
use App\Infrastructure\Listeners\LogContactScoreProcessed;
use App\Infrastructure\Listeners\BroadcastContactScoreProcessed;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    protected $listen = [
        ContactScoreProcessed::class => [
            LogContactScoreProcessed::class,
            BroadcastContactScoreProcessed::class,
        ],
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
