<?php

namespace iiifx\Component\Payment\Webmoney;

/**
 * Class PaymentResponse
 *
 * @package iiifx\Component\Payment\Webmoney
 */
class PaymentResponse {

    /**
     * @var array
     */
    private $fieldList = array (
        'LMI_PAYMENT_NO'     => 'int',
        'LMI_SYS_INVS_NO'    => 'int',
        'LMI_SYS_TRANS_NO'   => 'int',
        'LMI_SYS_TRANS_DATE' => 'string'
    );

    /**
     * @var int
     */
    private $LMI_PAYMENT_NO;
    /**
     * @var int
     */
    private $LMI_SYS_INVS_NO;
    /**
     * @var int
     */
    private $LMI_SYS_TRANS_NO;
    /**
     * @var string
     */
    private $LMI_SYS_TRANS_DATE;

    #
    ### Аццессоры #############################################################
    #

    /**
     * @return int
     */
    public function getPaymentId () {
        return $this->LMI_PAYMENT_NO;
    }

    /**
     * @return int
     */
    public function getPaymentInvoiseId () {
        return $this->LMI_SYS_INVS_NO;
    }

    /**
     * @return int
     */
    public function getPaymentTransferId () {
        return $this->LMI_SYS_TRANS_NO;
    }

    /**
     * @return string
     */
    public function getTransferDate () {
        return $this->LMI_SYS_TRANS_DATE;
    }

    #
    ### Экшны и хелперы #######################################################
    #

    /**
     * @param array $arrayData
     */
    public function loadFromArray ( $arrayData ) {
        if ( $arrayData && is_array( $arrayData ) ) {
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