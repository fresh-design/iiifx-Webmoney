<?php

namespace iiifx\Component\Payment\Qiwi;

/**
 * Class PaymentRequest
 *
 * @package iiifx\Qiwi
 */
class PaymentRequest {

    /**
     *
     */
    const PaymentType_Default = 'qw';
    const PaymentType_Any = 'qw';
    const PaymentType_Mobile = 'mobile';

    /**
     *
     */
    const LifetimeSeconds_TenMinutes = 600;
    const LifetimeSeconds_OneHour = 3600;
    const LifetimeSeconds_OneDay = 86400;
    const LifetimeSeconds_OneWeek = 604800;

    /**
     * @var int
     */
    private $shopId;
    /**
     * @var int
     */
    private $apiId;
    /**
     * @var string
     */
    private $apiPassword;
    /**
     * @var string
     */
    private $paymentType;
    /**
     * @var string
     */
    private $clientPhone;
    /**
     * @var float
     */
    private $paymentAmount;
    /**
     * @var string
     */
    private $currencyCode;
    /**
     * @var string
     */
    private $paymentComment;
    /**
     * @var int
     */
    private $lifetimeSeconds;
    /**
     * @var string
     */
    private $shopName;

    /**
     * @var int
     */
    private $_transactionId;
    /**
     * @var string
     */
    private $_responseData;
    /**
     * @var string
     */
    private $_requestError;

    /**
     * @param int    $shopId
     * @param int    $apiId
     * @param string $apiPassword
     */
    public function __construct ( $shopId = NULL, $apiId = NULL, $apiPassword = NULL ) {
        $shopId && $this->setShopId( $shopId );
        $apiId && $this->setApiId( $apiId );
        $apiPassword && $this->setApiPassword( $apiPassword );
    }

    /**
     * @param int $apiId
     *
     * @return PaymentRequest
     */
    public function setApiId ( $apiId ) {
        $this->apiId = (int) $apiId;
        return $this;
    }

    /**
     * @return int
     */
    public function getApiId () {
        return $this->apiId;
    }

    /**
     * @param string $apiPassword
     *
     * @return PaymentRequest
     */
    public function setApiPassword ( $apiPassword ) {
        $this->apiPassword = trim( $apiPassword );
        return $this;
    }

    /**
     * @return string
     */
    public function getApiPassword () {
        return $this->apiPassword;
    }

    /**
     * @param string $clienPhone
     *
     * @return PaymentRequest
     */
    public function setClientPhone ( $clienPhone ) {
        $this->clientPhone = '+' . trim( $clienPhone, ' +' );
        return $this;
    }

    /**
     * @return string
     */
    public function getClientPhone () {
        return $this->clientPhone;
    }

    /**
     * @param string $currencyCode
     *
     * @return PaymentRequest
     */
    public function setCurrencyCode ( $currencyCode ) {
        $this->currencyCode = strtoupper( $currencyCode );
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyCode () {
        return $this->currencyCode;
    }

    /**
     * @param float $paymentAmount
     *
     * @return PaymentRequest
     */
    public function setPaymentAmount ( $paymentAmount ) {
        $this->paymentAmount = number_format( $paymentAmount, 3, '.', '' );
        return $this;
    }

    /**
     * @return float
     */
    public function getPaymentAmount () {
        return $this->paymentAmount;
    }

    /**
     * @param string $paymentComment
     *
     * @return PaymentRequest
     */
    public function setPaymentComment ( $paymentComment ) {
        $this->paymentComment = trim( $paymentComment );
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentComment () {
        return $this->paymentComment;
    }

    /**
     * @param int $paymentLifetime
     *
     * @return PaymentRequest
     */
    public function setLifetimeSeconds ( $paymentLifetime ) {
        $this->lifetimeSeconds = (int) $paymentLifetime;
        return $this;
    }

    /**
     * @return int
     */
    public function getLifetimeSeconds () {
        return $this->lifetimeSeconds;
    }

    /**
     * @param string $paymentType
     *
     * @return PaymentRequest
     */
    public function setPaymentType ( $paymentType ) {
        $this->paymentType = $paymentType;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentType () {
        return $this->paymentType;
    }

    /**
     * @param int $shopId
     *
     * @return PaymentRequest
     */
    public function setShopId ( $shopId ) {
        $this->shopId = $shopId;
        return $this;
    }

    /**
     * @return int
     */
    public function getShopId () {
        return $this->shopId;
    }

    /**
     * @param string $responseData
     *
     * @return PaymentRequest
     */
    private function setResponseData ( $responseData ) {
        $this->_responseData = $responseData;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponseData () {
        return $this->_responseData;
    }

    /**
     * @return array
     */
    public function getResponseDataArray () {
        return json_decode( $this->getResponseData(), TRUE );
    }

    /**
     * @return mixed
     */
    public function getTransactionId () {
        if ( is_null( $this->_transactionId ) ) {
            $this->_transactionId = 'WP-' . date( 'ymd-His-' ) . rand( 100, 999 );
        }
        return $this->_transactionId;
    }

    /**
     * @param string $requestError
     *
     * @return PaymentRequest
     */
    public function setRequestError ( $requestError ) {
        $this->_requestError = $requestError;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestError () {
        return $this->_requestError;
    }

    /**
     * @param string $shopName
     *
     * @return PaymentRequest
     */
    public function setShopName ( $shopName ) {
        $this->shopName = trim( $shopName );
        return $this;
    }

    /**
     * @return string
     */
    public function getShopName () {
        return $this->shopName;
    }

    /**
     * @return bool|string
     */
    public function getPaymentFormattedLifetime () {
        return date( \DateTime::ISO8601, time() + $this->getLifetimeSeconds() );
    }

    /**
     * @return array
     */
    public function getRequestData () {
        return array (
            'user'       => 'tel:' . $this->getClientPhone(),
            'amount'     => $this->getPaymentAmount(),
            'ccy'        => $this->getCurrencyCode(),
            'comment'    => $this->getPaymentComment(),
            'lifetime'   => $this->getPaymentFormattedLifetime(),
            'pay_source' => $this->getPaymentType(),
            'prv_name'   => ' ' . $this->getShopName()
        );
    }

    /**
     * @return bool
     */
    public function validateData () {
        if ( $this->getShopId() <= 0 ) {
            return FALSE;
        }
        if ( $this->getApiId() <= 0 ) {
            return FALSE;
        }
        if ( !$this->getApiPassword() ) {
            return FALSE;
        }
        if ( preg_match( '/^\+\d{1,15}$/', $this->getClientPhone() ) <= 0 ) {
            return FALSE;
        }
        if ( $this->getPaymentAmount() <= 0 ) {
            return FALSE;
        }
        if ( preg_match( '/^[A-Z]{3}$/', $this->getCurrencyCode() ) <= 0 ) {
            return FALSE;
        }
        if ( $this->getLifetimeSeconds() <= 0 ) {
            return FALSE;
        }
        if ( !$this->getPaymentType() ) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * @return PaymentResponse
     */
    public function doRequest () {
        $curl = curl_init( 'https://w.qiwi.com/api/v2/prv/' . $this->getShopId() . '/bills/' . $this->getTransactionId() );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'PUT' );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query( $this->getRequestData() ) );
        curl_setopt( $curl, CURLOPT_POST, 1 );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, TRUE );
        curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $curl, CURLOPT_USERPWD, $this->getApiId() . ':' . $this->getApiPassword() );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array ( 'Accept: application/json' ) );
        if ( $results = curl_exec( $curl ) ) {
            $this->setResponseData( $results );
        } else {
            $this->setRequestError( curl_error( $curl ) );
        }
        curl_close( $curl );
        return new PaymentResponse( $this );
    }

}