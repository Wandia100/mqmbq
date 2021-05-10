<?php
    $db_host="";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_mpesa";
	$server_name = $_SERVER['SERVER_NAME'];
	$comp21coke = array( '18.222.117.89','www.comp21.co.ke', 'comp21.co.ke' );
	$comp21net = array( '18.190.157.46','www.comp21.net', 'comp21.net' );
	$comp21dev = array( '18.222.117.89','www.comp21.co.ke', 'comp21.co.ke' );
	if ( ( in_array($server_name, $comp21coke))) {
		$db_host      = "18.191.217.111";
    }
	else if ( ( in_array($server_name, $comp21net))) {
		$db_host      = "3.16.157.158";
    }
	else if ( ( in_array($server_name, $comp21dev))) {
		$db_host      = "3.16.157.158";
    }
	 else {
		$db_host      = "127.0.0.1";
		$db_username = "com2120";
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
