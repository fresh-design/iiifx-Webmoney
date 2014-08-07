<?php

require_once( 'PaymentForm.php' );

use iiifx\Component\Payment\Webmoney\PaymentResponse;

$webmoneyResponse = new PaymentResponse();

# Загружаем данные
$webmoneyResponse->loadFromPOST();

# Получаем номер заказа
$orderId = $webmoneyResponse->getPaymentId();

if ( $webmoneyResponse->getPaymentInvoiseId() && $webmoneyResponse->getPaymentTransferId() ) {

    /*
     * Оплата выполнена, т.к. мы получили ID трансфера и счета
     *
     * !!! Нельзя подтверждать оплату заказа на основе этих данных !!!
     *
     * Эти данные имеют информационный характер и должны использоваться лишь для отображения
     */

}