<?php

namespace Esmaily\FileManager;

use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        define('DS',DIRECTORY_SEPARATOR);
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'fileManager');
        $this->registerHelpers();

        $this->publishes([
            __DIR__.'/' => resource_path('views/vendor/filemanager'),
        ],'filemanager-views');
        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('filemanager'),
        ],'filemanager-assets');

        $this->publishes([
            __DIR__ . '/../Config/filemanager.php' => config_path('filemanager.php'),
        ],'filemanager-config');

        $this->app->bind('flashMessage',function(){
            return new FlashMessage();
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->mergeConfigFrom(__DIR__.'/../Config/filemanager.php','filemanager');
//        $this->app->singleton(FlashMessage::class,function($app){
//            return $app['flashMessage']=new FlashMessage();
//        });
    }
    public function registerHelpers()
    {
        // Load the helpers in app/Http/helpers.php
        if (file_exists($file = __DIR__.'/helpers.php'))
        {
            require $file;
        }
    }
}
