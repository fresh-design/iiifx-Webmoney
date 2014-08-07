<?php

require_once( 'PaymentVerify.php' );

use iiifx\Component\Payment\Webmoney\PaymentVerify;

$testingMode = TRUE;

$sellerPurse = 'Z145179295679';
$sellerPassword = '###';
$orderId = 1000;

$webmoneyWerify = new PaymentVerify( $sellerPurse, $sellerPassword );

# Загружаем данные
$webmoneyWerify->loadFromPOST();

# Проверяем подпись
if ( $webmoneyWerify->verifyResponseSignature() ) {
    # Успешно

    # Получаем данные оплаты
    $orderId = $webmoneyWerify->getPaymentId();
    # Или с переданных данных, если его передавали
    $orderId = $webmoneyWerify->getCustomerValue( 'orderId' );
    # ... и другое
    $invoiseId = $webmoneyWerify->getPaymentInvoiseId();
    $transferId = $webmoneyWerify->getPaymentTransferId();
    $transferDate = date( 'Y.m.d H', $webmoneyWerify->getTransferTimestamp() );
    $paymentAmount = $webmoneyWerify->getPaymentAmount();

    /**
     * Проверяем данные: сверяем номер заказа, сумму, записываем в логи
     *
     * Усли все в порядке - отдаем 'Yes'
     */

    echo 'Yes';

} else {
    # Ошибка, подпись не совпадает
}