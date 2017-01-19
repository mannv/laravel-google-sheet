<?php
/**
 * Created by PhpStorm.
 * User: mannv
 * Date: 1/19/2017
 * Time: 4:45 PM
 */
namespace Kayac\Sheet;
use Illuminate\Support\ServiceProvider;
class CallRouteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(CallRoute::class);
    }


    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        
        $configPath = __DIR__ . '/../config/kayacsheet.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('kayacsheet.php');
        } else {
            $publishPath = base_path('config/kayacsheet.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');
    }
}