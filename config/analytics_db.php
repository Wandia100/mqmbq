<?php
    $db_host="";
    $db_username = "comp2120";
	$db_password = "Zpa@!%vfrG34f";
	$db_name = "comp21_analytics";
	$server_name = $_SERVER['SERVER_NAME'];
	if ( ( in_array($server_name, COMP21_COKE))) {
		$db_host      = "3.137.150.45";
    }
	else if ( ( in_array($server_name,COMP21_NET))) {
		$db_host      ="18.118.148.138";
    }
	else if ( ( in_array($server_name,COMP21_DEV))) {
		$db_host      = "18.190.154.11";
    }
	 else {
		$db_host      = "127.0.0.1";
		$db_username = "com2120";
		$db_password = "Zpa@!%vfrG34f";
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
