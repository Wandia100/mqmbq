<?php
	
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.ANALYTICS_HOST.';dbname='.ANALYTICS_DB,
    'username' => DB_USERNAME,
    'password' => DB_PASSWORD,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
