<?php
	$host_name = $_SERVER['SERVER_NAME'];
	if ( ( in_array($host_name, COMP21_COKE))) {
		$db_host      = "3.137.150.45";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_analytics";
    }
	else if ( ( in_array($host_name,COMP21_NET))) {
		$db_host      ="18.118.148.138";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_analytics";
    }
	else if ( ( in_array($host_name,COMP21_DEV))) {
		$db_host      = "18.190.154.11";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_analytics";
    }
	else if ( ( in_array($host_name,CMEDIA_COTZ))) {
		$db_host      = "3.144.125.204";
    $db_username = "cmedia2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "cmedia_analytics";
    }
    else if ( ( in_array($host_name,EFMTZ_COM))) {
      $db_host      = "13.58.61.240";
      $db_username = "efmtz2120";
      $db_password = "Zpa@!%vfrG34f";
      $db_name = "efmtz_analytics";
      }
      else if ( ( in_array($host_name,BANDIKABANDUA))) {
        $db_host      = "analyticsdb.tzpromo.com";
        $db_username = "bandika_analytics";
        $db_password = "Zpa@!%vfrG34f";
        $db_name = "bandika_analytics";
        }       
	 else {
		$db_host      = "127.0.0.1";
		$db_username = "com2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_analytics";
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
