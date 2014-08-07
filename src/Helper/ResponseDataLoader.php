<?php

namespace iiifx\Component\Payment\Webmoney\Helper;

/**
 * Class ResponseDataLoader
 * @package iiifx\Component\Payment\Webmoney\Helper
 *
 * @property array $fieldList;
 * @property array $responseData
 */
trait ResponseDataLoader {

    /**
     * @param array $arrayData
     */
    public function loadFromArray ( $arrayData ) {
        if ( $arrayData && is_array( $arrayData ) ) {
            $this->responseData = $arrayData;
            foreach ( $this->fieldList as $fieldName => $fieldType ) {
                if ( isset( $arrayData[ $fieldName ] ) ) {
                    $fieldValue = $arrayData[ $fieldName ];
                    if ( $fieldType === 'int' ) {
                        $fieldValue = (int) $fieldValue;
                    }
                    $this->$fieldName = $fieldValue;
                }
            }
        }
    }

    /**
     * @return $this
     */
    public function loadFromPOST () {
        $this->loadFromArray( $_POST );
        return $this;
    }


}