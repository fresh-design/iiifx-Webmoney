<?php

namespace iiifx\Component\Payment\Webmoney;

/**
 * Class PaymentForm
 * @package iiifx\Component\Payment\Webmoney
 */
class PaymentForm {

    /**
     * @var string
     */
    private $webmoneyGateLink = 'https://merchant.webmoney.ru/lmi/payment.asp';

    /**
     * Режимы тестирования
     */
    const TestingMode_AllSuccess = 0;
    const TestingMode_AllCancel = 1;
    const TestingMode_Success80Cancel20 = 2;

    /**
     * Режимы отправки ответа, по умолчанию POST
     */
    const ResponseMethod_GET = 0;
    const ResponseMethod_POST = 1;
    const ResponseMethod_LINK = 2;

    /**
     * Доп. методы оплаты
     */
    const EInvoicingType_MoneyTransferSystem = 0;
    const EInvoicingType_AlphaClick = 3;
    const EInvoicingType_RussianBanksCards = 4;
    const EInvoicingType_RussianStandartBanking = 5;
    const EInvoicingType_BankingVTB24 = 6;
    const EInvoicingType_SberbankBonus = 7;
    const EInvoicingType_UkraineBanksAndTerminals = 8;
    const EInvoicingType_Cards = 10;

    /**
     * Еще методы оплаты
     */
    const AuthType_KeeperLight = 'authtype_2';
    const AuthType_WMCard = 'authtype_3';
    const AuthType_KeeperMobile = 'authtype_4';
    const AuthType_Enum = 'authtype_5';
    const AuthType_Paymer = 'authtype_6';
    const AuthType_Terminal = 'authtype_7';
    const AuthType_KeeperClassic = 'authtype_8';
    const AuthType_KeeperMini = 'authtype_9';
    const AuthType_WMNote = 'authtype_10';
    const AuthType_RussianPost = 'authtype_11';
    const AuthType_KeeperSocial = 'authtype_12';
    const AuthType_WMCheck = 'authtype_13';
    const AuthType_RussianRemittance = 'authtype_14';
    const AuthType_RussianCreditCard = 'authtype_16';
    const AuthType_MobilePayment = 'authtype_17';
    const AuthType_InternetBanking = 'authtype_18';
    const AuthType_SberbankBonus = 'authtype_19';

    /**
     * @var string
     */
    private $sellerPurse;
    /**
     * @var bool
     */
    private $testingMode;
    /**
     * @var string
     */
    private $formTagId;
    /**
     * @var bool
     */
    private $formAutoSubmit;
    /**
     * @var float
     */
    private $paymentAmount;
    /**
     * @var int
     */
    private $paymentId;
    /**
     * @var string
     */
    private $comment;
    /**
     * @var int
     */
    private $eInvoicingType;
    /**
     * @var string
     */
    private $authType;
    /**
     * @var string
     */
    private $resultLink;
    /**
     * @var string
     */
    private $successLink;
    /**
     * @var int
     */
    private $successMethod;
    /**
     * @var string
     */
    private $failLink;
    /**
     * @var int
     */
    private $failMethod;

    /**
     * @var array
     */
    private $customerValueList = array ();

    /**
     * @param string $sellerPurse
     */
    public function __construct ( $sellerPurse ) {
        $this->setSellerPurse( $sellerPurse );
    }

    #
    ### Аццессоры #############################################################
    #

    /**
     * @return string
     */
    public function getWebmoneyGateLink () {
        return $this->webmoneyGateLink;
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
     * @param string $failLink
     *
     * @return $this
     */
    public function setFailLink ( $failLink ) {
        $this->failLink = $failLink;
        return $this;
    }

    /**
     * @return string
     */
    public function getFailLink () {
        return $this->failLink;
    }

    /**
     * @param string $resultLink
     *
     * @return $this
     */
    public function setResultLink ( $resultLink ) {
        $this->resultLink = $resultLink;
        return $this;
    }

    /**
     * @return string
     */
    public function getResultLink () {
        return $this->resultLink;
    }

    /**
     * @param string $successLink
     *
     * @return $this
     */
    public function setSuccessLink ( $successLink ) {
        $this->successLink = $successLink;
        return $this;
    }

    /**
     * @return string
     */
    public function getSuccessLink () {
        return $this->successLink;
    }

    /**
     * @param int $failMethod
     *
     * @return $this
     */
    public function setFailMethod ( $failMethod ) {
        $this->failMethod = $failMethod;
        return $this;
    }

    /**
     * @return int
     */
    public function getFailMethod () {
        if ( is_null( $this->failMethod ) ) {
            $this->failMethod = self::ResponseMethod_POST;
        }
        return $this->failMethod;
    }

    /**
     * @param int $successMethod
     *
     * @return $this
     */
    public function setSuccessMethod ( $successMethod ) {
        $this->successMethod = $successMethod;
        return $this;
    }

    /**
     * @return int
     */
    public function getSuccessMethod () {
        if ( is_null( $this->successMethod ) ) {
            $this->successMethod = self::ResponseMethod_POST;
        }
        return $this->successMethod;
    }

    /**
     * @param int $testingMode
     *
     * @return $this
     */
    public function setTestingMode ( $testingMode ) {
        $this->testingMode = $testingMode;
        return $this;
    }

    /**
     * @return int
     */
    public function getTestingMode () {
        return $this->testingMode;
    }

    /**
     * @param string $authType
     *
     * @return $this
     */
    public function setAuthType ( $authType ) {
        $this->authType = $authType;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthType () {
        return $this->authType;
    }

    /**
     * @param  string$comment
     *
     * @return $this
     */
    public function setComment ( $comment ) {
        $this->comment = trim( $comment );
        return $this;
    }

    /**
     * @return string
     */
    public function getComment () {
        return $this->comment;
    }

    /**
     * @param int $eInvoicingType
     *
     * @return $this
     */
    public function setEInvoicingType ( $eInvoicingType ) {
        $this->eInvoicingType = $eInvoicingType;
        return $this;
    }

    /**
     * @return int
     */
    public function getEInvoicingType () {
        return $this->eInvoicingType;
    }

    /**
     * @param float $paymentAmount
     *
     * @return $this
     */
    public function setPaymentAmount ( $paymentAmount ) {
        $this->paymentAmount = number_format( $paymentAmount, 2, '.', '' );
        return $this;
    }

    /**
     * @return float
     */
    public function getPaymentAmount () {
        return $this->paymentAmount;
    }

    /**
     * @param int $paymentId
     *
     * @return $this
     */
    public function setPaymentId ( $paymentId ) {
        $this->paymentId = (int) $paymentId;
        return $this;
    }

    /**
     * @return int
     */
    public function getPaymentId () {
        return $this->paymentId;
    }

    /**
     * @param string $formTagId
     *
     * @return $this
     */
    public function setFormTagId ( $formTagId ) {
        $this->formTagId = trim( $formTagId );
        return $this;
    }

    /**
     * @return string
     */
    public function getFormTagId () {
        if ( is_null( $this->formTagId ) ) {
            $this->formTagId = 'webmoney-form-' . md5( microtime() );
        }
        return $this->formTagId;
    }

    /**
     * @return string
     */
    public function getBase64Comment () {
        if ( !is_null( $this->getComment() ) ) {
            return base64_encode( $this->getComment() );
        }
        return '';
    }

    /**
     * @param string $valueName
     * @param string $valueData
     *
     * @return $this
     */
    public function addCustomerValue ( $valueName, $valueData = NULL ) {
        if ( is_array( $valueName ) ) {
            $this->addCustomerValues( $valueName );
        } else {
            if ( $valueData ) {
                $this->customerValueList[ trim( $valueName ) ] = $valueData;
            }
        }
        return $this;
    }

    /**
     * @param array $valueList
     *
     * @return $this
     */
    public function addCustomerValues ( $valueList ) {
        if ( $valueList && is_array( $valueList ) ) {
            foreach ( $valueList as $valueName => $valueData ) {
                $this->addCustomerValue( $valueName, $valueData );
            }
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function clearCustomerValues () {
        $this->customerValueList = array ();
        return $this;
    }

    /**
     * @return array
     */
    public function getCustomerValues () {
        return $this->customerValueList;
    }

    /**
     * @return $this
     */
    public function enableFormAutoSubmit () {
        $this->formAutoSubmit = TRUE;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableFormAutoSubmit () {
        $this->formAutoSubmit = FALSE;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabledFormAutoSubmit () {
        return !!$this->formAutoSubmit;
    }

    #
    ### Экшны и хелперы #######################################################
    #

    /**
     * @return bool
     */
    public function validateData () {
        if ( preg_match( '/^[ZREUD]{1}\d{12}$/iu', $this->getSellerPurse() ) !== 1 ) {
            return FALSE;
        }
        if ( $this->getPaymentAmount() <= 0  ) {
            return FALSE;
        }
        if ( $this->getPaymentId() <= 0 ) {
            return FALSE;
        }
        if ( !$this->getComment() ) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * @return string
     */
    public function buildFormView () {
        $formTagId = ( !is_null( $this->getFormTagId() ) ) ? "id=\"{$this->getFormTagId()}\"" : NULL;
        $formAuthType = ( !is_null( $this->getAuthType() ) ) ? "?at={$this->getAuthType()}" : NULL;
        $inputsData = <<<HTML
    <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="{$this->getPaymentAmount()}">
    <input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="{$this->getBase64Comment()}">
    <input type="hidden" name="LMI_PAYMENT_NO" value="{$this->getPaymentId()}">
    <input type="hidden" name="LMI_PAYEE_PURSE" value="{$this->getSellerPurse()}">
HTML;
        if ( !is_null( $this->getTestingMode() ) ) {
            $inputsData .= <<<HTML
\n    <input type="hidden" name="LMI_SIM_MODE" value="{$this->getTestingMode()}">
HTML;
        }
        if ( !is_null( $this->getResultLink() ) ) {
            $inputsData .= <<<HTML
\n    <input type="hidden" name="LMI_RESULT_URL" value="{$this->getResultLink()}">
HTML;
        }
        if ( !is_null( $this->getSuccessLink() ) ) {
            $inputsData .= <<<HTML
\n    <input type="hidden" name="LMI_SUCCESS_URL" value="{$this->getSuccessLink()}">
HTML;
        }
        if ( !is_null( $this->getSuccessMethod() ) ) {
            $inputsData .= <<<HTML
\n    <input type="hidden" name="LMI_SUCCESS_METHOD" value="{$this->getSuccessMethod()}">
HTML;
        }
        if ( !is_null( $this->getFailLink() ) ) {
            $inputsData .= <<<HTML
\n    <input type="hidden" name="LMI_FAIL_URL" value="{$this->getFailLink()}">
HTML;
        }
        if ( !is_null( $this->getFailMethod() ) ) {
            $inputsData .= <<<HTML
\n    <input type="hidden" name="LMI_FAIL_METHOD" value="{$this->getFailMethod()}">
HTML;
        }
        if ( !is_null( $this->getEInvoicingType() ) ) {
            $inputsData .= <<<HTML
\n    <input type="hidden" name="LMI_ALLOW_SDP" value="{$this->getEInvoicingType()}">
HTML;
        }
        if ( $this->getCustomerValues() ) {
            foreach ( $this->getCustomerValues() as $name => $value ) {
                $inputsData .= <<<HTML
\n    <input type="hidden" name="CUSTOMER_{$name}" value="{$value}">
HTML;
            }
        }
        if ( $this->isEnabledFormAutoSubmit() ) {
            $submitScript = <<<HTML
<script type="text/javascript">
    document.getElementById( '{$this->getFormTagId()}' ).submit();
</script>
HTML;
        } else {
            $submitScript = NULL;
        }
        $inputsData = ltrim( $inputsData, "\r\n" );
        return <<<HTML
<!--suppress ALL -->
<form method="POST" {$formTagId} action="{$this->getWebmoneyGateLink()}{$formAuthType}">
{$inputsData}
</form>
{$submitScript}
HTML;
    }

}