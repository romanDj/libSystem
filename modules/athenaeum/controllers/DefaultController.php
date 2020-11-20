<?php

namespace app\modules\athenaeum\controllers;

use yii\web\Response;

class DefaultController extends \yii\rest\Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        \Yii::$app->response->format = Response::FORMAT_HTML;
        return $this->render('index');
    }
}
