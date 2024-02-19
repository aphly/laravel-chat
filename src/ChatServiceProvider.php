<?php
namespace Aphly\LaravelChat;

use Aphly\Laravel\Providers\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
		$this->mergeConfigFrom(
            __DIR__.'/config/chat.php', 'chat'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/chat.php' => config_path('chat.php'),
            __DIR__.'/public' => public_path('static/chat')
        ]);
        //$this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'laravel-chat');
        $this->loadViewsFrom(__DIR__.'/views/front/'.config('common.template'), 'laravel-chat-front');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }

}
