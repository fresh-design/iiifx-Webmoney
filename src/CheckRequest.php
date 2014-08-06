<?php

namespace iiifx\Component\Payment\Qiwi;

/**
 * Class CheckRequest
 *
 * @package iiifx\Qiwi
 */
class CheckRequest {

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
    private $transactionId;

    /**
     * @var
     */
    private $_responseData;
    /**
     * @var
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
     * @return CheckRequest
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
     * @return CheckRequest
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
     * @param string $transactionId
     *
     * @return CheckRequest
     */
    public function setTransactionId ( $transactionId ) {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionId () {
        return $this->transactionId;
    }

    /**
     * @param int $shopId
     *
     * @return CheckRequest
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
     * @return CheckRequest
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
     * @param string $requestError
     *
     * @return CheckRequest
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
     * @return CheckResponse
     */
    public function doRequest () {
        $curl = curl_init( 'https://w.qiwi.com/api/v2/prv/' . $this->getShopId() . '/bills/' . $this->getTransactionId() );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );
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
        return new CheckResponse( $this );
    }

}