<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use common\models\Specialty;
use common\models\Group;
use common\models\Course;
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
    	foreach(\Yii::$app->survey->listGroups($surveyId) as $gData) {
    		if($gData['id']['language'] == 'ro' && $gData['group_name'] == 'META') {
    			foreach(\Yii::$app->survey->listQuestions($surveyId, $gData['id']['gid']) as $qData)
    			{
    				if($qData['title'] == 'SPECIALITATEA')
    				{
    					$props = Yii::$app->survey->getQuestionProperties($qData['id']['qid'], ['answeroptions','question','attributes']);
    					$specs = Specialty::find()->all();
    					foreach($specs as $spec)
    					{
    						$yes = false;
    						foreach($props['answeroptions'] as $opt)
    						{
    							if(strtolower($spec->name) == strtolower($opt['answer']))
    							{
    								$yes = true;
    								break;
    							}
    						}
    						if(!$yes)
    						{
    							$missing['specialties'][] = $spec->name;
    						}		
    					}
    				}
    				if($qData['title'] == 'GRUPA')
    				{
    					$props = Yii::$app->survey->getQuestionProperties($qData['id']['qid'], ['answeroptions','question','attributes']);
    					$groups = Group::find()->all();
    					foreach($groups as $group)
    					{
    						$yes = false;
    						foreach($props['answeroptions'] as $opt)
    						{
    							if(strtolower($group->name) == strtolower($opt['answer']))
    							{
    								$yes = true;
    								break;
    							}
    						}
    						if(!$yes)
    						{
    							$missing['groups'][] = $group->name;
    						}
    					}
    				}
    				if($qData['title'] == 'DISCIPLINA')
    				{
    					$props = Yii::$app->survey->getQuestionProperties($qData['id']['qid'], ['answeroptions','question','attributes']);
    					$courses = Course::find()->all();
    					foreach($courses as $course)
    					{
    						$yes = false;
    						foreach($props['answeroptions'] as $opt)
    						{
    							if(strtolower($course->name) == strtolower($opt['answer']))
    							{
    								$yes = true;
    								break;
    							}
    						}
    						if(!$yes)
    						{
    							$missing['courses'][] = $course->name;
    						}
    					}
    				}
    				if($qData['title'] == 'PROFESORUL')
    				{
    					$props = Yii::$app->survey->getQuestionProperties($qData['id']['qid'], ['answeroptions','question','attributes']);
    					$instrs = Instructor::find()->all();
    					foreach($instrs as $instr)
    					{
    						$yes = false;
    						foreach($props['answeroptions'] as $opt)
    						{
    							if(strtolower($instr->full_name) == strtolower($opt['answer']))
    							{
    								$yes = true;
    								break;
    							}
    						}
    						if(!$yes)
    						{
    							$missing['instructors'][] = $instr->full_name;
    						}
    					}
    				}
    			}	
    		}
    	}    	

        return $this->render('index', [
        		'active' => $active, 
        		'missing' => $missing
        		
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
}
