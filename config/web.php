<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$mpesa_db = require __DIR__ . '/mpesa_db.php';
$sms_db = require __DIR__ . '/sms_db.php';
$analytics_db = require __DIR__ . '/analytics_db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log',QUEUE_NAME],
    'defaultRoute' =>'site/index',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'com211',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'mpesa_db' => $mpesa_db,
        'sms_db' => $sms_db,
        'analytics_db'=>$analytics_db,
        QUEUE_NAME => [
            'class' => \yii\queue\amqp_interop\Queue::class,
            'port' => 5672,
            'user' => QUEUE_NAME,
            'password' => QUEUE_PASSWORD,
            'queueName' => QUEUE_NAME,
            'driver' => yii\queue\amqp_interop\Queue::ENQUEUE_AMQP_LIB,
            'dsn' => 'amqp://'.QUEUE_NAME.':'.QUEUE_PASSWORD.'@127.0.0.1:5672/'.QUEUE_VHOST,
            'ttr' => 43200,
           
        ],
        'myhelper'        => [
                'class' => 'app\components\Myhelper',
        ],
		'urlManager'      => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
		],
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // your other grid module settings
        ],
       'gridviewKrajee' =>  [
            'class' => '\kartik\grid\Module',
            // your other grid module settings
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
