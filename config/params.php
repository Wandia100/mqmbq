<?php

use app\models\Transactions;

include "api_credentials.php";
include "credentials.php";
return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    
    'reportscontrollers'=>['mpesapayments','Transactions','transactionhistories','winninghistories','financialsummaries','commissions','disbursements','site'],
    'noncashitems' => ['b0356880-7e3e-11eb-9c65-8d380353c292'],
    'barcodeGenerateIfEmpty' => true,
];
