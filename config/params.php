<?php
define( 'PARTYA', '3015585' );
define( 'REMARKS', 'Remarks' );
define( 'QUEUETIMEOUTURL',"https://comp21.co.ke/api/disbursement-payment-timeout-result" );
define( 'RESULTURL',"https://comp21.co.ke/api/disbursement-payment-result-confirmation" );
define( 'INITIATORNAME',"com21.api" );
define( 'OCCASION',"Occasion");
define( 'MPESAPAYMENTREQUESTURL',"https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest");
define( 'MPESATOKENURL',"https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials");

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    
    'reportscontrollers'=>['mpesapayments','transactionhistories','winninghistories','financialsummaries','commissions','disbursements']
];
