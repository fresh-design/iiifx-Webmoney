<?php

require_once( 'PaymentVerify.php' );

use iiifx\Component\Payment\Webmoney\PaymentVerify;

$testingMode = TRUE;

$sellerPurse = 'Z145179295679';
$orderId = 1000;

$webmoneyWerify = new PaymentVerify( $sellerPurse );

# Загружаем данные
$webmoneyResponse->loadFromPOST();

# Проверяем подпись
if ( $webmoneyWerify->verifyResponseSignature() ) {



} else {
    # Ошибка, подпись не совпадает
}