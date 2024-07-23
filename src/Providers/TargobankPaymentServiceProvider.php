<?php

namespace TargobankPayment\Providers;

use Plenty\Plugin\ServiceProvider;
use TargobankPayment\Helper\TargobankHelper;
use Plenty\Modules\Payment\Events\Checkout\ExecutePayment;
use Plenty\Modules\Basket\Events\GetPaymentMethodContent;
use Plenty\Modules\EventProcedures\Services\Entries\ProcedureEntry;
use Plenty\Plugin\Events\Dispatcher;

class TargobankPaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->register(TargobankHelper::class);
    }

    public function boot(Dispatcher $eventDispatcher)
    {
        $eventDispatcher->listen(GetPaymentMethodContent::class, function(GetPaymentMethodContent $event) {
            $this->getApplication()->make(TargobankHelper::class)->getPaymentMethodContent($event);
        });

        $eventDispatcher->listen(ExecutePayment::class, function(ExecutePayment $event) {
            $this->getApplication()->make(TargobankHelper::class)->executePayment($event);
        });
    }
}
