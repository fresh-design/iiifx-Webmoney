<?php

namespace iiifx\Component\Payment\Webmoney;

/*
Контрольная подпись "Формы оповещения о платеже", которая
используется для проверки целостности полученной информации.
Подпись формируется путем MD5-шифрование строки, полученной
путем склейки (без разделителей) значений следующих параметров
точно в указанном порядке:

LMI_PAYEE_PURSE
LMI_PAYMENT_AMOUNT
LMI_PAYMENT_NO
LMI_MODE
LMI_SYS_INVS_NO
LMI_SYS_TRANS_NO
LMI_SYS_TRANS_DATE
LMI_SECRET_KEY (Secret Key)
LMI_PAYER_PURSE
LMI_PAYER_WM

MD5-строка передаётся в верхнем регистре
*/

class PaymentVerify {

    use Helper\ResponseDataLoader;
    use Helper\ResponseCustomerFields;

    private $fieldList = array (
        'LMI_PAYMENT_AMOUNT',
        'LMI_PAYMENT_NO',
        'LMI_PAYEE_PURSE',
        'LMI_MODE',
        'LMI_SYS_INVS_NO',
        'LMI_SYS_TRANS_NO',
        'LMI_PAYER_PURSE',
        'LMI_PAYER_WM',
        'LMI_SYS_TRANS_DATE',
        'LMI_HASH',
    );

}