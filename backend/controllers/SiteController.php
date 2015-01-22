<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use common\models\Faculty;
use common\models\StudyCycle;
use common\models\Specialty;
use common\models\Group;
use common\models\Course;
use common\models\ActivityType;
use common\models\Instructor;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
    	$surveyId = \Yii::$app->survey->surveyId;
    	$sp = Yii::$app->survey->getSurveyProperties($surveyId, ['sid', 'active', 'expires']);
    	if(isset($sp['active']) && $sp['active'] == 'Y' && empty($sp['expires']))
    		$active = true;
    	else
    		$active = false;
    	
    	
    	$missing = ['specialties' => [], 'groups' => [], 'courses' => [], 'instructors' => []];
    	$nonCorrespondence = [];
    	foreach(\Yii::$app->survey->listGroups($surveyId) as $gData) {
    		if($gData['id']['language'] == 'ro' && $gData['group_name'] == 'META') {
    			foreach(\Yii::$app->survey->listQuestions($surveyId, $gData['id']['gid']) as $qData)
    			{
    			    switch($qData['title'])
    			    {
    			        case 'FACULTATEA':
    			            $nonCorrespondence['FACULTATEA'] = $this->checkNonCorrespondence(
    			                $qData['id']['qid'], 
    			                Faculty::find()->orderBy(['id' => SORT_ASC])->all(), 
    			                function($model){return $model->name;}
    			            );
    			            break;
    			        case 'CICLUL':    
    			            $nonCorrespondence['CICLUL'] = $this->checkNonCorrespondence(
    			                $qData['id']['qid'], 
    			                StudyCycle::find()->orderBy(['id' => SORT_ASC])->all(), 
    			                function($model){return $model->name;}
    			            );
    			            break;
    			        case 'SPECIALITATEA':    
    			            $nonCorrespondence['SPECIALITATEA'] = $this->checkNonCorrespondence(
    			                $qData['id']['qid'], 
    			                Specialty::find()->orderBy(['id' => SORT_ASC])->all(), 
    			                function($model){return $model->name;}
    			            );
    			            break;
    			        case 'GRUPA':    
    			            $nonCorrespondence['GRUPA'] = $this->checkNonCorrespondence(
    			                $qData['id']['qid'], 
    			                Group::find()->orderBy(['id' => SORT_ASC])->all(), 
    			                function($model){return $model->name;}
    			            );
    			            break;
    			        case 'DISCIPLINA':    
    			            $nonCorrespondence['DISCIPLINA'] = $this->checkNonCorrespondence(
    			                $qData['id']['qid'], 
    			                Course::find()->orderBy(['id' => SORT_ASC])->all(), 
    			                function($model){return $model->name;}
    			            );
    			            break;
    			        case 'ACTIVITATEA':    
    			            $nonCorrespondence['ACTIVITATEA'] = $this->checkNonCorrespondence(
    			                $qData['id']['qid'], 
    			                ActivityType::find()->orderBy(['id' => SORT_ASC])->all(), 
    			                function($model){return $model->name;}
    			            );
    			            break;
    			        case 'PROFESORUL':    
    			            $nonCorrespondence['PROFESORUL'] = $this->checkNonCorrespondence(
    			                $qData['id']['qid'], 
    			                Instructor::find()->orderBy(['id' => SORT_ASC])->all(), 
    			                function($model){return $model->full_name;}
    			            );
    			            break;
    			    }
    			}	
    		}
    	}    	
    	
    	
    	// summary
    	$summary = null;
    	if($active)
    	{	
    		$command = \Yii::$app->getDb()->createCommand('SELECT ROUND(AVG(cnt)) AS avg FROM (SELECT COUNT(*) AS cnt FROM group_activity WHERE semester_id=1 GROUP BY group_id) AS cnts');
    		$rows = $command->queryAll();
    		    		
    		$summary  = \Yii::$app->survey->getSummary($surveyId);
    		$summary['students'] = round($summary['full_responses'] / $rows[0]['avg']);
    	}
    	
        return $this->render('index', [
        		'active' => $active, 
        		'missing' => $missing,
        		'nonCorrespondence' => $nonCorrespondence,
        		'summary' => $summary,
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    /* Helpers */
    
    public function checkNonCorrespondence($questionId, $models, $modelNameFunc)
    {
        $result = [];
        $props = Yii::$app->survey->getQuestionProperties($questionId, ['answeroptions']);
        //$models = Faculty::find()->orderBy(['id' => SORT_ASC])->all();
        foreach($models as $model)
    	{
    	    if(!isset($props['answeroptions'][$model->id]) || strtolower($modelNameFunc($model)) !== strtolower($props['answeroptions'][$model->id]['answer']))
    	    {
    	        $result[] = ['code' => $model->id, 'answer' => $modelNameFunc($model)];
    	    }
    	}
    	
    	return $result;
    }   
}
