<?php

namespace frontend\controllers;

use common\models\Faculty;
use common\models\StudyCycle;
use common\models\StudyForm;
use common\models\Specialty;
use common\models\Group;

class SurveyController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	if(!empty($_GET['f']) && empty($_GET['sc']))
    	{
    		$studyCycles = StudyCycle::find()->all();
    		return $this->render('index', ['studyCycles' => $studyCycles, 'f' => $_GET['f']]);
    	}

    	if(!empty($_GET['sc']) && empty($_GET['sf']))
    	{
    		$studyForms = StudyForm::find()->all();
    		return $this->render('index', ['studyForms' => $studyForms, 'f' => $_GET['f'], 'sc' => $_GET['sc']]);
    	}
    	
    	if(!empty($_GET['sf']))
    	{
    		$specialties = Specialty::find()
    			->andFilterWhere(['faculty_id' => $_GET['f']])
    			->andFilterWhere(['study_cycle_id' => $_GET['sc']])
    			->all();
    		return $this->render('index', ['specialties' => $specialties]);
    	}

    	if(!empty($_GET['s']))
    	{
    		$groups = Group::find()
    		->andFilterWhere(['specialty_id' => $_GET['s']])
    		->all();
    		return $this->render('index', ['groups' => $groups]);
    	}
    	
    	if(!empty($_GET['g']))
    	{
    		$groups = Group::find()
    		->andFilterWhere(['specialty_id' => $_GET['s']])
    		->all();
    		return $this->render('index', ['groups' => $groups]);
    	}
    	 
        $faculties = Faculty::find()->all();
        return $this->render('index', ['faculties' => $faculties]);
    }
}