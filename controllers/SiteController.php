<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;

class SiteController extends Controller
{

    public $layout = false;

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        return $this->render('index');
    }
    
}
