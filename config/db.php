<?php
       
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.MAIN_HOST.';dbname='.MAIN_DB,
    'username' => MAIN_USERNAME,
    'password' => MAIN_DB_PASSWORD,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
