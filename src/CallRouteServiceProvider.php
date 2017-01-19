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
}