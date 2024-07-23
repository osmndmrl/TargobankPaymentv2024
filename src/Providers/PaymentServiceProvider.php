<?php

namespace Payment\Providers;

use Plenty\Plugin\ServiceProvider;

/**
 * Class PaymentServiceProvider
 * @package Payment\Providers
 */
class PaymentServiceProvider extends ServiceProvider
{
    /**
    * Register the route service provider
    */
    public function register()
    {
        $this->getApplication()->register(PaymentRouteServiceProvider::class);
    }
}