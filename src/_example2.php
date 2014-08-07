<?php

require_once( 'PaymentForm.php' );

use iiifx\Component\Payment\Webmoney\PaymentResponse;

/*
 * !!! Нельзя подтверждать оплату заказа на основе этих данных !!!
 *
 * Эти данные имеют информационный характер и должны использоваться лишь для отображения
 */

$webmoneyResponse = new PaymentResponse();

# Загружаем данные
$webmoneyResponse->loadFromPOST();

# Получаем номер заказа
$orderId = $webmoneyResponse->getPaymentId();
# Или с переданных данных, если его передавали
$orderId = $webmoneyResponse->getCustomerValue( 'orderId' );
# Номер счета оплаты, если успешно завершилась
$invoiseId = $webmoneyResponse->getPaymentInvoiseId();
# Номер трансфера, если успешно завершилась
$transferId = $webmoneyResponse->getPaymentTransferId();
# Дату проведения оплаты, если успешно завершилась
$transferDate = date( 'Y.m.d H', $webmoneyResponse->getTransferTimestamp() );