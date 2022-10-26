<?php
	
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.SMS_HOST.';dbname='.SMS_DB,
    'username' => SMS_USERNAME,
    'password' => SMS_DB_PASSWORD,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
