<?php

namespace iiifx\Component\Payment\Webmoney;

class PaymentForm {

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

}