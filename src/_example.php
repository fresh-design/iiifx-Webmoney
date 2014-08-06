<?php

require_once( 'PaymentRequest.php' );
require_once( 'PaymentResponse.php' );
require_once( 'CheckRequest.php' );
require_once( 'CheckResponse.php' );

#
### Настройки платежа #########################################################
#

$orderId = 998;
$shopId = 123123;
$apiId = 12123123;
$apiPassword = 'secretApiPassword';
$clientPhone = '+380990009900';
$currencyCode = 'RUB';
$orderAmount = 1.00;

#
### Выставляем счет платежа ###################################################
#

$qiwiPaymentRequest = new \iiifx\Component\Payment\Qiwi\PaymentRequest( $shopId, $apiId, $apiPassword );
# Задаем данные платежа
$qiwiPaymentRequest
    ->setClientPhone( $clientPhone ) # Телефон клиента: +380683626568
    ->setPaymentAmount( $orderAmount ) # Сумма оплаты: 111.00
    ->setCurrencyCode( $currencyCode ) # Валюта, трехсимвольный код ISO4217: RUB
    ->setPaymentComment( "Оплата заказа #{$orderID}" ) # Комментарий к оплате
    ->setLifetimeSeconds( \iiifx\Component\Payment\Qiwi\PaymentRequest::LifetimeSeconds_OneDay ) # Время жизни счета, в секундах
    ->setPaymentType( \iiifx\Component\Payment\Qiwi\PaymentRequest::PaymentType_Any ) # Тип оплаты
    ->setShopName( 'WePlay' );
if ( !$qiwiPaymentRequest->validateData() ) {
    # Ошибка данных оплаты
} else {
    # Делаем запрос, получаем ответ
    $qiwiResponse = $qiwiPaymentRequest->doRequest();
    # Проверяем результат
    if ( $qiwiResponse->isSuccess() ) {
        # $transactionId = $qiwiPaymentRequest->getTransactionId();
        # Ссылка на редирект пользователя, для оплаты
        echo $qiwiResponse->getClientRedireckLink();
    } else {
        # Код ошибки
        echo $qiwiResponse->getErrorCode();
    }
}

#
### Проверяем статус платежа ##################################################
#

$qiwiCheckRequest = new \iiifx\Component\Payment\Qiwi\CheckRequest( $shopId, $apiId, $apiPassword );
# Устанавливаем номер транзакции
$qiwiCheckRequest->setTransactionId( 'WP-140805-181439-386' /*$transactionId*/ );
# Делаем запрос, получаем ответ
$qiwiResponse = $qiwiCheckRequest->doRequest();
# Проверяем результат
if ( $qiwiResponse->isSuccess() ) {
    if ( $qiwiResponse->isPaidStatus() ) {
        # Заказ успешно оплачен
    } elseif ( $qiwiResponse->isWaitingStatus() ) {
        # Оплата заказа ожидается
    } else {
        # Оплата была отменена или просрочена
    }
} else {
    # Не удалось проверить статус оплаты
    echo $qiwiResponse->getErrorCode();
}