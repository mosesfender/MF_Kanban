<?php

namespace mf\kanban\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        prer(\yii::$app->user,1,1);
        return $this->render('index');
    }
}