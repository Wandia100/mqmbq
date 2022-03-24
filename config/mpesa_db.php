<?php
	$host_name = gethostname();
	if ( ( in_array($host_name, [COMP21_COKE]))) {
		$db_host      = "18.191.217.111";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_mpesa";
    }
	else if ( ( in_array($host_name, [COMP21_NET]))) {
		$db_host      = "3.16.157.158";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_mpesa";
    }
	else if ( ( in_array($host_name, [COMP21_DEV]))) {
		$db_host      = "moneydb.comp21.dev";
    $db_username = "comp2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "comp21_mpesa";
    }
  else if ( ( in_array($host_name,[BANDIKABANDUA]))) {
      $db_host      = "moneydb.tzpromo.com";
      $db_username = "bandika_money";
      $db_password = "Zpa@!%vfrG34f";
      $db_name = "bandika_money";
      }
  else if ( ( in_array($host_name,[MCHEZOBOMBA]))) {
        $db_host      = "moneydb.tzpromos.com";
        $db_username = "mchezo_money";
        $db_password = "Zpa@!%vfrG34f";
        $db_name = "mchezo_money";
        }            
	else if ( ( in_array($host_name, [CMEDIA_COTZ]))) {
		
    $db_host      = "3.21.41.249";
    $db_username = "cmedia2120";
    $db_password = "Zpa@!%vfrG34f";
    $db_name = "cmedia_mpesa";
    }
    else if ( ( in_array($host_name,[EFMTZ_COM]))) {
      $db_host      = "18.216.231.0";
      $db_username = "efmtz_mpesa";
      $db_password = "Zpa@!%vfrG34f";
      $db_name = "efmtz_mpesa";
      }
      else if ( ( in_array($host_name,[MCHEZOSUPA]))) {
        $db_host      = "moneydb.tzg255.com";
        $db_username = "itv2220";
        $db_password = "Zpa@!%vfrG34f";
        $db_name = "itv_money";
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
