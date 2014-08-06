<?php

namespace iiifx\Component\Payment\Qiwi;

/**
 * Class CheckResponse
 *
 * @package iiifx\Qiwi
 */
class CheckResponse {

    /**
     * @var CheckRequest
     */
    private $checkRequest;

    /**
     * @param CheckRequest $checkRequest
     */
    public function __construct ( CheckRequest $checkRequest ) {
        $this->checkRequest = clone $checkRequest;
    }

    /**
     * @return CheckRequest
     */
    public function getParent () {
        return $this->checkRequest;
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
     * @return null
     */
    public function getPaymentStatus () {
        $responseData = $this->getParent()->getResponseDataArray();
        if ( isset( $responseData[ 'response' ][ 'bill' ][ 'status' ] ) ) {
            return $responseData[ 'response' ][ 'bill' ][ 'status' ];
        }
        return NULL;
    }

    /**
     * @return bool
     */
    public function isPaidStatus () {
        return ( $this->getPaymentStatus() === 'paid' );
    }

    /**
     * @return bool
     */
    public function isWaitingStatus () {
        return ( $this->getPaymentStatus() === 'waiting' );
    }

}