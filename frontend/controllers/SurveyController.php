<?php

namespace frontend\controllers;

use common\models\Faculty;

class SurveyController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $faculties = Faculty::find()->all();
        return $this->render('index', ['faculties' => $faculties]);
    }
}
