<?php
	
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.MONEY_HOST.';dbname='.MONEY_DB,
    'username' => MONEY_USERNAME,
    'password' => MONEY_DB_PASSWORD,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
