<?php

namespace Payment\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Class PaymentRouteServiceProvider
 * @package Payment\Providers
 */
class PaymentRouteServiceProvider extends RouteServiceProvider
{
    /**
     * @param Router $router
     */
    public function map(Router $router)
    {
        $router->get('hello-world','Payment\Controllers\PaymentController@getHelloWorldPage');
    }
}