<?php
	$host_name =gethostname();
	if ( ( in_array($host_name, [COMP21_COKE]))) {
		$db_host      = "3.141.4.51";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21";
    }
	else if ( ( in_array($host_name,[COMP21_NET]))) {
		$db_host      ="18.222.4.78";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21";
    }
	else if ( ( in_array($host_name,[COMP21_DEV]))) {
		$db_host      = "db.comp21.dev";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21";
    }
	else if ( ( in_array($host_name,[CMEDIA_COTZ]))) {
		$db_host      = "db.cmedia.co.tz";
    $db_username = "cmedia2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "cmedia";
    }
	else if ( ( in_array($host_name,[BANDIKABANDUA]))) {
		$db_host      = "db.tzpromo.com";
    $db_username = "bandika";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "bandika";
    }
  else if ( ( in_array($host_name,[MCHEZOBOMBA]))) {
      $db_host      = "db.tzpromos.com";
      $db_username = "mchezo";
      $db_password = "Zpa@!%vfrG34f";
      $db_name = "mchezo";
      }      
    else if ( ( in_array($host_name,[EFMTZ_COM]))) {
      $db_host      = "db.efmtz.com";
      $db_username = "efmtz2120";
      $db_password = "Zpa@!%vfrG34f";
      $db_name = "efmtz";
      }
	 else {
		$db_host      = "127.0.0.1";
		$db_username = "com2120";
		$db_password = "Zpa@!%vfrG34f";
		$db_name = "com21";
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
