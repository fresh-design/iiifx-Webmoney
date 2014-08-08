<?php

namespace iiifx\Component\Payment\Webmoney;

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

    /**
     * @return int
     */
    public function getPaymentId () {
        return $this->getResponseValue( 'LMI_PAYMENT_NO' );
    }

    /**
     * @return int
     */
    public function getPaymentInvoiseId () {
        return $this->getResponseValue( 'LMI_SYS_INVS_NO' );
    }

    /**
     * @return int
     */
    public function getPaymentTransferId () {
        return $this->getResponseValue( 'LMI_SYS_TRANS_NO' );
    }

    /**
     * @return string
     */
    public function getTransferDate () {
        return $this->getResponseValue( 'LMI_SYS_TRANS_DATE' );
    }

    /**
     * @return int|null
     */
    public function getTransferTimestamp () {
        if ( $this->getTransferDate() ) {
            return strtotime( $this->getTransferDate() );
        }
        return NULL;
    }

    /**
     * @return null|string
     */
    public function getPayerPurse () {
        return $this->getResponseValue( 'LMI_PAYER_PURSE' );
    }

    /**
     * @return null|string
     */
    public function getPayerWM () {
        return $this->getResponseValue( 'LMI_PAYER_WM' );
    }

    /**
     * @return null|string
     */
    public function getPaymentAmount () {
        return $this->getResponseValue( 'LMI_PAYMENT_AMOUNT' );
    }

    /**
     * @return string
     */
    public function buildSignatureString () {
        return
            $this->getSellerPurse() .
            $this->getResponseValue( 'LMI_PAYMENT_AMOUNT' ) .
            $this->getResponseValue( 'LMI_PAYMENT_NO' ) .
            $this->getResponseValue( 'LMI_MODE' ) .
            $this->getResponseValue( 'LMI_SYS_INVS_NO' ) .
            $this->getResponseValue( 'LMI_SYS_TRANS_NO' ) .
            $this->getResponseValue( 'LMI_SYS_TRANS_DATE' ) .
            $this->getSellerPassword() .
            $this->getResponseValue( 'LMI_PAYER_PURSE' ) .
            $this->getResponseValue( 'LMI_PAYER_WM' );
    }

    public function buildControlSignature () {
        return strtoupper( md5( $this->buildSignatureString() ) );
    }

    /**
     * @return bool
     */
    public function verifyResponseSignature () {
        return ( $this->getResponseValue( 'LMI_HASH' ) === $this->buildControlSignature() );
    }

}