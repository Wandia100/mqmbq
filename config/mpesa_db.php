<?php
    $db_host="";
    $db_username="";
    $db_password="";
    $db_name="";
	$server_name = $_SERVER['SERVER_NAME'];
	$live_server = array( '18.222.117.89','www.comp21.co.ke', 'comp21.co.ke' );
	if ( ( in_array($server_name, $live_server ))) {
		$db_host      = "3.141.4.51";
		$db_username = "comp2120";
		$db_password = "Zpa@!%vfrG34f";
		$db_name = "comp21_mpesa";
    }
	 else {
		$db_host      = "127.0.0.1";
		$db_username = "com2120";
		$db_password = "Zpa@!%vfrG34f";
		$db_name = "comp21_mpesa";
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
