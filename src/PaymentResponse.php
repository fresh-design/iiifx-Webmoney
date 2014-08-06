<?php

namespace iiifx\Component\Payment\Qiwi;

/**
 * Class PaymentResponse
 *
 * @package iiifx\Qiwi
 */
class PaymentResponse {

    /**
     * @var PaymentRequest
     */
    private $paymentRequest;

    /**
     * @param PaymentRequest $paymentRequest
     */
    public function __construct ( PaymentRequest $paymentRequest ) {
        $this->paymentRequest = clone $paymentRequest;
    }

    /**
     * @return PaymentRequest
     */
    public function getParent () {
        return $this->paymentRequest;
    }

    /**
     * @return bool
     */
    public function isSuccess () {
        return ( !is_null( $this->getErrorCode() ) && $this->getErrorCode() === 0 );
    }

    /**
     * @return bool
     */
    public function isError () {
        return ( is_null( $this->getErrorCode() ) || $this->getErrorCode() !== 0 );
    }

    /**
     * @return int|null
     */
    public function getErrorCode () {
        $responseData = $this->getParent()->getResponseDataArray();
        if ( isset( $responseData[ 'response' ][ 'result_code' ] ) ) {
            return (int) $responseData[ 'response' ][ 'result_code' ];
        }
        return NULL;
    }

    /**
     * @param string $succesUrl
     * @param string $failUrl
     *
     * @return string
     */
    public function getClientRedireckLink ( $succesUrl = NULL, $failUrl = NULL ) {
        $linkString = 'https://w.qiwi.com/order/external/main.action?shop=' . $this->getParent()->getShopId() .
            '&transaction=' . $this->getParent()->getTransactionId() . '&qiwi_phone=' . $this->getParent()->getClientPhone();
        if ( $failUrl ) {
            $linkString .= '&failUrl=' . urlencode( urldecode( $failUrl ) );
        }
        if ( $succesUrl ) {
            $linkString .= '&successUrl=' . urlencode( urldecode( $succesUrl ) );
        }
        return $linkString;
    }

}