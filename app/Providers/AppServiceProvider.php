<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (App::isLocal()) {
            Schema::defaultStringLength(191);
        }

        if (App::isProduction()) {
            // Listen for Artisan commands
            Event::listen(CommandStarting::class, function (CommandStarting $event) {
                $destructiveCommands = [
                    'migrate:fresh',
                    'migrate:reset',
                    'migrate:refresh',
                    'db:wipe',
                ];
    
                if (in_array($event->command, $destructiveCommands)) {
                    throw new \RuntimeException("The '{$event->command}' command is not allowed in production.");
                }
            });
        }
    }
}
