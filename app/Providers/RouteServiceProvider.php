<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {        
        $router->group(['namespace' => $this->namespace,'prefix' => 'amp'], function ($router) {
            require app_path('Routes/amp.php');            
        });
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Routes/other_top.php');
        });
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Routes/web.php');
        });
        $router->group(['namespace' => $this->namespace,'prefix' => 'admin'], function ($router) {
            require app_path('Routes/admin.php');            
        });
        $router->group(['namespace' => $this->namespace,'prefix' => 'api'], function ($router) {
            require app_path('Routes/api.php');            
        });
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Routes/other_bottom.php');
        });        
    }
}
