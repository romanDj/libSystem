<?php

namespace app\modules\foo;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\foo\controllers';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => CompositeAuth::className(),
//            'authMethods' => [
//                HttpBearerAuth::className(),
//                QueryParamAuth::className(),
//            ],
//        ];
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
}
