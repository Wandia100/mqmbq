<?php
	$server_name = $_SERVER['SERVER_NAME'];
	if ( ( in_array($server_name,COMP21_COKE ))) {
		$db_host      = "18.188.98.88";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_sms";
    }
	else if ( ( in_array($server_name,COMP21_NET ))) {
		$db_host      =  "3.142.221.86";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_sms";
    }
	else if ( ( in_array($server_name,COMP21_DEV ))) {
		$db_host      =  "18.217.3.231";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_sms";
    }
	else if ( ( in_array($server_name,CMEDIA_COTZ ))) {
		$db_host      =  "18.118.134.230";
    $db_username = "cmedia2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "cmedia_sms";
    }
	 else {
		$db_host      = "127.0.0.1";
		$db_username = "com2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_sms";
     }
       
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.$db_host.';dbname='.$db_name,
    'username' => $db_username,
    'password' => $db_password,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
