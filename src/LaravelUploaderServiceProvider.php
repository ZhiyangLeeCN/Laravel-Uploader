<?php namespace LaravelUploader;

/**
 * Created by PhpStorm.
 * User: zhiyanglee
 * Date: 2015/12/31
 * Time: 19:29
 */

use Illuminate\Support\ServiceProvider;
use LaravelUploader\Contracts\Uploader\UploaderConfigManager as UploaderConfigManagerContract;

class LaravelUploaderServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     *
     */
    public function boot()
    {
        $uploaderConfig = $this->app['config.uploader'];

        $this->app->bind(UploaderConfigManagerContract::class, function() use($uploaderConfig) {

            return new UploaderConfigManager($uploaderConfig);

        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $uploaderConfigFilePath = realpath(__DIR__ . '/../config/uploader.php');

        $this->mergeConfigFrom($uploaderConfigFilePath, 'uploader');
        $this->publishes([$uploaderConfigFilePath => config_path('uploader.php')], 'config');
    }
}