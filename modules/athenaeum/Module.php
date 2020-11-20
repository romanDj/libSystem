<?php

namespace app\modules\athenaeum;

use yii\base\BootstrapInterface;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'app\modules\athenaeum\controllers';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'OPTIONS', 'PATCH', 'POST', 'PUT', 'DELETE'],
                'Access-Control-Request-Headers' => ['Authorization', 'Content-Type'],
                'Access-Control-Max-Age' => 3600
            ]
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['default/index']
        ];
        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => 'yii\rest\UrlRule',
                'controller' => $this->id . '/book',
                'prefix' => 'v1'
            ],
            [
                'class' => 'yii\rest\UrlRule',
                'controller' => $this->id . '/author',
                'prefix' => 'v1'
            ]
        ], false);
    }

}
