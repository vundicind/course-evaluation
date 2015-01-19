<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SurveyController extends Controller
{
	public function actionActivate()
	{
		$surveyId = \Yii::$app->get('survey')->surveyId;
		Yii::$app->survey->activateSurvey($surveyId);
		Yii::$app->survey->setSurveyProperties($surveyId, ['expires' => '']);
		
		return $this->goHome();
	}
	
	public function actionDeactivate()
	{
		$surveyId = \Yii::$app->get('survey')->surveyId;		
		Yii::$app->survey->setSurveyProperties($surveyId, ['expires' => date("Y-m-d H:i:s")]);

		return $this->goHome();
	}
	
}