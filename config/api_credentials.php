<?php
$server_name = $_SERVER['SERVER_NAME'];
define( 'COMP21_COKE', array( '18.222.117.89','www.comp21.co.ke', 'comp21.co.ke'));
define( 'COMP21_NET',  array( '18.190.157.46','www.comp21.net', 'comp21.net' ));
define( 'COMP21_DEV',  array( '3.15.207.63','www.comp21.dev', 'comp21.dev'));
define( 'CMEDIA_COTZ',  array( 'cmedia.co.tz','www.cmedia.co.tz'));
define( 'NITEXTSMSURL',"https://nitext.co.ke/index.php/api/sendSmsMultiple");
if ( ( in_array($server_name,COMP21_COKE))) {
    define( 'PARTYA', '3015585' );
    define( 'REMARKS', 'Remarks' );
    define( 'QUEUETIMEOUTURL',"https://comp21.co.ke/api/disbursement-payment-timeout-result" );
    define( 'RESULTURL',"https://comp21.co.ke/api/disbursement-payment-result-confirmation" );
    define( 'INITIATORNAME',"com21.api" );
    define( 'OCCASION',"Occasion");
    define( 'MPESAPAYMENTREQUESTURL',"https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest");
    define( 'MPESATOKENURL',"https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials");
}
else if ( ( in_array($server_name,COMP21_NET))) {
    define( 'PARTYA', '3015585' );
    define( 'REMARKS', 'Remarks' );
    define( 'QUEUETIMEOUTURL',"https://comp21.net/api/disbursement-payment-timeout-result" );
    define( 'RESULTURL',"https://comp21.net/api/disbursement-payment-result-confirmation" );
    define( 'INITIATORNAME',"com21.api" );
    define( 'OCCASION',"Occasion");
    define( 'MPESAPAYMENTREQUESTURL',"https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest");
    define( 'MPESATOKENURL',"https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials");
}
else if ( ( in_array($server_name,COMP21_DEV))) {
    define( 'PARTYA', '161744' );
    define( 'REMARKS', 'Remarks' );
    define( 'QUEUETIMEOUTURL',"https://comp21.dev/api/disbursement-payment-timeout-result" );
    define( 'RESULTURL',"https://comp21.dev/api/disbursement-payment-result-confirmation" );
    define( 'INITIATORNAME',"pigakazi.api" );
    define( 'OCCASION',"Occasion");
    define( 'MPESAPAYMENTREQUESTURL',"https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest");
    define( 'MPESATOKENURL',"https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials");
}
 else {
    define( 'PARTYA', '3015585' );
    define( 'REMARKS', 'Remarks' );
    define( 'QUEUETIMEOUTURL',"https://comp21.co.ke/api/disbursement-payment-timeout-result" );
    define( 'RESULTURL',"https://comp21.co.ke/api/disbursement-payment-result-confirmation" );
    define( 'INITIATORNAME',"com21.api" );
    define( 'OCCASION',"Occasion");
    define( 'MPESAPAYMENTREQUESTURL',"https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest");
    define( 'MPESATOKENURL',"https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials");
 }

?>