<?php

namespace iiifx\Component\Payment\Webmoney;

/*
Контрольная подпись "Формы оповещения о платеже", которая
используется для проверки целостности полученной информации.
Подпись формируется путем MD5-шифрование строки, полученной
путем склейки (без разделителей) значений следующих параметров
точно в указанном порядке:

LMI_PAYEE_PURSE
LMI_PAYMENT_AMOUNT
LMI_PAYMENT_NO
LMI_MODE
LMI_SYS_INVS_NO
LMI_SYS_TRANS_NO
LMI_SYS_TRANS_DATE
LMI_SECRET_KEY (Secret Key)
LMI_PAYER_PURSE
LMI_PAYER_WM

MD5-строка передаётся в верхнем регистре
*/

/**
 * Class PaymentVerify
 * @package iiifx\Component\Payment\Webmoney
 */
class PaymentVerify {

    use Helper\ResponseDataLoader;
    use Helper\ResponseCustomerFields;

    /**
     * @var array
     */
    private $fieldList = array (
        'LMI_PAYMENT_AMOUNT' => 'string',
        'LMI_PAYMENT_NO'     => 'string',
        'LMI_PAYEE_PURSE'    => 'string',
        'LMI_MODE'           => 'string',
        'LMI_SYS_INVS_NO'    => 'string',
        'LMI_SYS_TRANS_NO'   => 'string',
        'LMI_PAYER_PURSE'    => 'string',
        'LMI_PAYER_WM'       => 'string',
        'LMI_SYS_TRANS_DATE' => 'string',
        'LMI_HASH'           => 'string',
    );

    /**
     * @var array
     */
    private $signatureFieldList = array (
        'LMI_PAYEE_PURSE',
        'LMI_PAYMENT_AMOUNT',
        'LMI_PAYMENT_NO',
        'LMI_MODE',
        'LMI_SYS_INVS_NO',
        'LMI_SYS_TRANS_NO',
        'LMI_SYS_TRANS_DATE',
        'LMI_SECRET_KEY',
        'LMI_PAYER_PURSE',
        'LMI_PAYER_WM',
    );

    /**
     * @var array
     */
    private $responseData;

    /**
     * @var string
     */
    private $sellerPurse;

    /**
     * @var string
     */
    private $sellerPassword;

    /**
     * @param string $sellerPurse
     * @param string $sellerPassword
     */
    public function __construct ( $sellerPurse, $sellerPassword ) {
        $this->setSellerPurse( $sellerPurse );
        $this->setSellerPassword( $sellerPassword );
    }

    #
    ### Аццессоры #############################################################
    #

    /**
     * @param string $sellerPurse
     *
     * @return $this
     */
    public function setSellerPurse ( $sellerPurse ) {
        $this->sellerPurse = strtoupper( trim( $sellerPurse ) );
        return $this;
    }

    /**
     * @return string
     */
    public function getSellerPurse () {
        return $this->sellerPurse;
    }

    /**
     * @param string $sellerPassword
     */
    public function setSellerPassword ( $sellerPassword ) {
        $this->sellerPassword = trim( $sellerPassword );
    }

    /**
     * @return string
     */
    public function getSellerPassword () {
        return $this->sellerPassword;
    }

    #
    ### Хелперы ###############################################################
    #

    /**
     * @return bool
     */
    public function verifyResponseSignature() {
        return TRUE;
    }

}