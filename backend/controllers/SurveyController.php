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
		
		//https://github.com/phemellc/yii2-settings
		//Yii::$app->settings.set('survey.semester', 1, )
		
		return $this->goHome();
	}
	
	public function actionDeactivate()
	{
		$surveyId = \Yii::$app->get('survey')->surveyId;		
		Yii::$app->survey->setSurveyProperties($surveyId, ['expires' => date("Y-m-d H:i:s")]);

		return $this->goHome();
	}
	
}