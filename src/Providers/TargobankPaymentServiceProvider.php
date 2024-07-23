<?php

namespace TargobankPayment\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Modules\Payment\Contracts\PaymentMethodContainer;
use TargobankPayment\Helper\TargobankHelper;
use Plenty\Modules\Payment\Events\Checkout\ExecutePayment;
use Plenty\Modules\Basket\Events\GetPaymentMethodContent;
use Plenty\Plugin\Events\Dispatcher;

class TargobankPaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->register(TargobankHelper::class);
    }

    public function boot(PaymentMethodContainer $payContainer, Dispatcher $eventDispatcher)
    {
        $payContainer->register('TargobankPayment::TARGOBANK', [
            'de' => 'TARGOBANK',
            'en' => 'TARGOBANK'
        ]);

        $eventDispatcher->listen(GetPaymentMethodContent::class, function(GetPaymentMethodContent $event) {
            $this->getApplication()->make(TargobankHelper::class)->getPaymentMethodContent($event);
        });

        $eventDispatcher->listen(ExecutePayment::class, function(ExecutePayment $event) {
            $this->getApplication()->make(TargobankHelper::class)->executePayment($event);
        });
    }
}
