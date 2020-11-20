<?php


namespace app\controllers;


use app\models\User;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\rest\Controller;

class ApiController extends ActiveController
{
    public $modelClass = User::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        return $behaviors;
    }
}
