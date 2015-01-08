<?php

namespace frontend\controllers;

//use backend\models\Faculty;

class SurveyController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $faculties = \backend\models\Faculty::find()->all();
        return $this->render('index', ['faculties' => $faculties]);
    }

}
