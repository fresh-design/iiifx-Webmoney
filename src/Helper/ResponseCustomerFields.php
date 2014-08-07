<?php

namespace iiifx\Component\Payment\Webmoney\Helper;

/**
 * Class ResponseCustomerFields
 * @package iiifx\Component\Payment\Webmoney\Helper
 *
 * @property array $responseData
 */
trait ResponseCustomerFields {

    /**
     * @param string $valueName
     *
     * @return string|null
     */
    public function getCustomerValue ( $valueName ) {
        if ( $valueName ) {
            $valueName = "CUSTOMER_{$valueName}";
            if ( isset( $this->responseData[ $valueName ] ) ) {
                return $this->responseData[ $valueName ];
            }
        }
        return NULL;
    }

}