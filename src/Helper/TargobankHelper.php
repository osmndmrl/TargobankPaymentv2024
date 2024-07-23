<?php

namespace TargobankPayment\Helper;

use Plenty\Modules\Basket\Events\GetPaymentMethodContent;
use Plenty\Modules\Payment\Events\Checkout\ExecutePayment;
use Plenty\Plugin\Http\Request;
use Plenty\Modules\Payment\Models\PaymentStatus;
use Plenty\Modules\Payment\Contracts\PaymentRepositoryContract;

class TargobankHelper
{
    private $paymentRepository;

    public function __construct(PaymentRepositoryContract $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function getPaymentMethodContent(GetPaymentMethodContent $event)
    {
        if ($event->getMop() == $this->getTargobankMopId()) {
            $content = $this->generateTargobankForm($event->getBasket());
            $event->setValue($content);
            $event->setType(GetPaymentMethodContent::HTML_CONTENT);
        }
    }

    public function executePayment(ExecutePayment $event)
    {
        if ($event->getMop() == $this->getTargobankMopId()) {
            // Ödeme işlemini gerçekleştir
            $paymentResult = $this->executeTargobankPayment($event->getOrderId());
            if ($paymentResult) {
                $event->setType('success');
                $event->setValue('Ödeme başarıyla gerçekleştirildi!');
            } else {
                $event->setType('error');
                $event->setValue('Ödeme gerçekleştirilemedi.');
            }
        }
    }

    private function getTargobankMopId()
    {
        // Targobank ödeme yöntemi ID'sini döndür
        return 12345; // Bu örnek bir ID, gerçek ID'yi buraya koymalısınız.
    }

    private function executeTargobankPayment($orderId)
    {
        // Targobank ödeme işlemini gerçekleştir
        // Bu örnek bir fonksiyon, burada Targobank API'si ile entegrasyonu yapmalısınız.
        // Ödeme sonucunu döndür (boolean).
        return true; // Bu örnek bir sonuç, gerçek sonucu API'den almanız gerekecek.
    }

    private function generateTargobankForm($basket)
    {
        $totalAmount = $basket->basketAmount;
        $orderId = $basket->id;

        $form = '
            <form id="targobank-payment-form" action="https://www.targobank.de/de/app/indirectloanrequest.html" method="POST" target="_blank">
                <input type="hidden" name="koop_id" value="villastore241">
                <input type="hidden" name="amount" value="' . $totalAmount . '">
                <input type="hidden" name="dealerID" value="804625">
                <input type="hidden" name="dealerText" value="https://yourshop.com/targobank/response">
                <input type="hidden" name="documentno" value="' . $orderId . '">
                <input type="submit" value="TARGOBANK ile Öde">
            </form>
        ';

        return $form;
    }
}
