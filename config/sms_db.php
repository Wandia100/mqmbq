<?php
	$host_name = gethostname();
	if ( ( in_array($host_name,[COMP21_COKE] ))) {
		$db_host      = "18.188.98.88";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_sms";
    }
	else if ( ( in_array($host_name,[COMP21_NET] ))) {
		$db_host      =  "3.142.221.86";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_sms";
    }
	else if ( ( in_array($host_name,[COMP21_DEV] ))) {
		$db_host      =  "smsdb.comp21.dev";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_sms";
    }
  else if ( ( in_array($host_name,[BANDIKABANDUA]))) {
      $db_host      = "smsdb.tzpromo.com";
      $db_username = "bandika_sms";
      $db_password = "Zpa@!%vfrG34f";
      $db_name = "bandika_sms";
      }    
  else if ( ( in_array($host_name,[MCHEZOBOMBA]))) {
        $db_host      = "smsdb.tzpromos.com";
        $db_username = "mchezo_sms";
        $db_password = "Zpa@!%vfrG34f";
        $db_name = "mchezo_sms";
        }        
	else if ( ( in_array($host_name,[CMEDIA_COTZ] ))) {
		$db_host      =  "18.118.134.230";
    $db_username = "cmedia2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "cmedia_sms";
    }
    else if ( ( in_array($host_name,[EFMTZ_COM]))) {
      $db_host      = "18.216.61.174";
      $db_username = "efmtz2120";
      $db_password = "Zpa@!%vfrG34f";
      $db_name = "efmtz_sms";
      }
      else if ( ( in_array($host_name,[MCHEZOSUPA]))) {
        $db_host      = "smsdb.tzg255.com";
        $db_username = "itv2220";
        $db_password = "Zpa@!%vfrG34f";
        $db_name = "itv_sms";
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
