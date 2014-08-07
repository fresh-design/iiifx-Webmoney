<?php

namespace iiifx\Component\Payment\Webmoney;

/**
 * Class PaymentResponse
 * @package iiifx\Component\Payment\Webmoney
 */
class PaymentResponse {

    use Helper\ResponseDataLoader;
    use Helper\ResponseCustomerFields;

    /**
     * @var array
     */
    protected $fieldList = array (
        'LMI_PAYMENT_NO'     => 'int',
        'LMI_SYS_INVS_NO'    => 'int',
        'LMI_SYS_TRANS_NO'   => 'int',
        'LMI_SYS_TRANS_DATE' => 'string'
    );

    /**
     * @var array
     */
    protected $responseData;

    #
    ### Аццессоры #############################################################
    #

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

}