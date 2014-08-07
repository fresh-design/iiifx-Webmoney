<?php

namespace iiifx\Component\Payment\Webmoney;

class PaymentForm {

    private $webmoneyGateLink = 'https://merchant.webmoney.ru/lmi/payment.asp';

    const TestingMode_AllSuccess = 0;
    const TestingMode_AllCancel = 1;
    const TestingMode_Success80Cancel20 = 2;

    const ResponseMethod_GET = 0;
    const ResponseMethod_POST = 1;
    const ResponseMethod_LINK = 2;

    const EInvoicingType_MoneyTransferSystem = 0;
    const EInvoicingType_AlphaClick = 3;
    const EInvoicingType_RussianBanksCards = 4;
    const EInvoicingType_RussianStandartBanking = 5;
    const EInvoicingType_BankingVTB24 = 6;
    const EInvoicingType_SberbankBonus = 7;
    const EInvoicingType_UkraineBanksAndTerminals = 8;
    const EInvoicingType_Cards = 10;

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

    private $sellerPurse;
    private $testingMode;
    private $formTagId;
    private $formAutoSubmit;
    private $paymentAmount;
    private $paymentId;
    private $comment;
    private $eInvoicingType;
    private $authType;
    private $resultLink;
    private $successLink;
    private $successMethod;
    private $failLink;
    private $failMethod;

    private $customerValueList = array ();

    public function __construct ( $sellerPurse ) {
        $this->setSellerPurse( $sellerPurse );
    }

    #
    ### Аццессоры #############################################################
    #

    public function getWebmoneyGateLink () {
        return $this->webmoneyGateLink;
    }

    public function setSellerPurse ( $sellerPurse ) {
        $this->sellerPurse = strtoupper( trim( $sellerPurse ) );
        return $this;
    }

    public function getSellerPurse () {
        return $this->sellerPurse;
    }

    public function setFailLink ( $failLink ) {
        $this->failLink = $failLink;
        return $this;
    }

    public function getFailLink () {
        return $this->failLink;
    }

    public function setResultLink ( $resultLink ) {
        $this->resultLink = $resultLink;
        return $this;
    }

    public function getResultLink () {
        return $this->resultLink;
    }

    public function setSuccessLink ( $successLink ) {
        $this->successLink = $successLink;
        return $this;
    }

    public function getSuccessLink () {
        return $this->successLink;
    }

    public function setFailMethod ( $failMethod ) {
        $this->failMethod = $failMethod;
        return $this;
    }

    public function getFailMethod () {
        if ( is_null( $this->failMethod ) ) {
            $this->failMethod = self::ResponseMethod_POST;
        }
        return $this->failMethod;
    }

    public function setSuccessMethod ( $successMethod ) {
        $this->successMethod = $successMethod;
        return $this;
    }

    public function getSuccessMethod () {
        if ( is_null( $this->successMethod ) ) {
            $this->successMethod = self::ResponseMethod_POST;
        }
        return $this->successMethod;
    }

    public function setTestingMode ( $testingMode ) {
        $this->testingMode = $testingMode;
        return $this;
    }

    public function getTestingMode () {
        return $this->testingMode;
    }

    public function setAuthType ( $authType ) {
        $this->authType = $authType;
        return $this;
    }

    public function getAuthType () {
        return $this->authType;
    }

    public function setComment ( $comment ) {
        $this->comment = trim( $comment );
        return $this;
    }

    public function getComment () {
        return $this->comment;
    }

    public function setEInvoicingType ( $eInvoicingType ) {
        $this->eInvoicingType = $eInvoicingType;
        return $this;
    }

    public function getEInvoicingType () {
        return $this->eInvoicingType;
    }

    public function setPaymentAmount ( $paymentAmount ) {
        $this->paymentAmount = number_format( $paymentAmount, 2, '.', '' );
        return $this;
    }

    public function getPaymentAmount () {
        return $this->paymentAmount;
    }

    public function setPaymentId ( $paymentId ) {
        $this->paymentId = (int) $paymentId;
        return $this;
    }

    public function getPaymentId () {
        return $this->paymentId;
    }

    public function setFormTagId ( $formTagId ) {
        $this->formTagId = trim( $formTagId );
        return $this;
    }

    public function getFormTagId () {
        if ( is_null( $this->formTagId ) ) {
            $this->formTagId = 'webmoney-form-' . md5( microtime() );
        }
        return $this->formTagId;
    }

    public function getBase64Comment () {
        if ( !is_null( $this->getComment() ) ) {
            return base64_encode( $this->getComment() );
        }
        return '';
    }

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

    public function addCustomerValues ( $valueList ) {
        if ( $valueList && is_array( $valueList ) ) {
            foreach ( $valueList as $valueName => $valueData ) {
                $this->addCustomerValue( $valueName, $valueData );
            }
        }
        return $this;
    }

    public function clearCustomerValues () {
        $this->customerValueList = array ();
        return $this;
    }

    public function getCustomerValues () {
        return $this->customerValueList;
    }

    public function enableFormAutoSubmit () {
        $this->formAutoSubmit = TRUE;
        return $this;
    }

    public function disableFormAutoSubmit () {
        $this->formAutoSubmit = FALSE;
        return $this;
    }

    public function isEnabledFormAutoSubmit () {
        return !!$this->formAutoSubmit;
    }

    #
    ### Экшны и хелперы #######################################################
    #

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