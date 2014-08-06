<?php

require_once( 'PaymentForm.php' );

use iiifx\Component\Payment\Webmoney\PaymentForm;

#
### Настройки платежа #########################################################
#

$testingMode = TRUE;

$sellerPurse = 'Z145179295679';
$orderId = 1000;

#
### Создание платежа ##########################################################
#

$webmoneyForm = new PaymentForm( $sellerPurse );

# Только для режима тестирования
if ( $testingMode ) {
    $webmoneyForm->setTestingMode( PaymentForm::TestingMode_AllSuccess );
}

# Можно пропустить
$webmoneyForm
    ->setSuccessMethod( PaymentForm::ResponseMethod_POST )
    ->setFailMethod( PaymentForm::ResponseMethod_POST );

# Настройка страниц
$webmoneyForm
    ->setResultLink( 'http://' )
    ->setSuccessLink( 'http://' )
    ->setFailLink( 'http://' );

# Направление на конкретный тип оплаты
$webmoneyForm->setAuthType( PaymentForm::AuthType_KeeperClassic );
$webmoneyForm->setEInvoicingType( PaymentForm::EInvoicingType_Cards );

# Параметры оплаты
$webmoneyForm
    ->setPaymentAmount( 1.00 )
    ->setPaymentId( $orderId )
    ->setComment( "Оплата заказа #{$orderId}" );

if ( $webmoneyForm->validateData() ) {

    $webmoneyForm->setFormTagId( 'webmoney-form' );

    # Получаем данные формы для отображения
    $formView = $webmoneyForm->buildFormView();

    # Отображаем форму пользователю
    echo $formView;

    # И сразу ее сабмитим, если нужно
    echo "
        <script type=\"text/javascript\">
            $( function () { $( 'form#webmoney-form' ).submit(); } );
        </script>";


} else {
    # Ошибка данных
}


