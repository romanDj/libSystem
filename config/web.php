<?php

use yii\web\GroupUrlRule;
use yii\rest\UrlRule;

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'micro-app',
    'language' => 'ru-RU',
    // the basePath of the application will be the `micro-app` directory
    'basePath' => dirname(__DIR__),
    // this is where the application will find all controllers
    'controllerNamespace' => 'app\controllers',
    // set an alias to enable autoloading of classes from the 'micro' namespace
    'aliases' => [
        //  '@app' => __DIR__,
    ],
    'bootstrap' => ['athenaeum'],
    'components' => [
        'db' => $db,
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'cookieValidationKey' => 'asdasdasfdawfuiahsdfasdf',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,

            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'prefix' => 'v1'
                ],
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'prefix' => 'v1',
                    'routePrefix' => '',
                    'rules' => [
                        'OPTIONS,POST user/login' => 'user/login',
                        'OPTIONS,POST user/register' => 'user/register',
                        'OPTIONS,GET user/profile' => 'user/profile',
                        'OPTIONS,DELETE user/profile' => 'user/profile-delete'
                    ]
                ],
            ],
        ]
    ],
    'modules' => [
        'athenaeum' => [
            'class' => 'app\modules\athenaeum\Module',
        ],
    ],
];


if (YII_ENV_DEV) {
//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = [
//        'class' => 'yii\gii\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
//        //'allowedIPs' => ['127.0.0.1', '::1'],
//    ];
}

return $config;
