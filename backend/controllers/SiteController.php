<?php
namespace backend\controllers;

use common\models\ActivityType;
use common\models\Course;
use common\models\Faculty;
use common\models\Group;
use common\models\Instructor;
use common\models\LoginForm;
use common\models\Specialty;
use common\models\StudyCycle;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function init()
    {
        parent::init();

        \Yii::$app->survey->surveyId = Yii::$app->settings->get('survey.surveyId', 'LimeSurvey');
        \Yii::$app->survey->username = Yii::$app->settings->get('survey.username', 'LimeSurvey');
        \Yii::$app->survey->password = Yii::$app->settings->get('survey.password', 'LimeSurvey');
        \Yii::$app->survey->url = Yii::$app->settings->get('survey.url', 'LimeSurvey');
    }

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
        if (isset($sp['active']) && $sp['active'] == 'Y' && empty($sp['expires']))
            $active = true;
        else
            $active = false;

        $missing = ['specialties' => [], 'groups' => [], 'courses' => [], 'instructors' => []];
        $nonCorrespondence = [];

        $sGroups = \Yii::$app->survey->listGroups($surveyId);
        if ($sGroups == null || isset($sGroups['status'])) $sGroups = [];
        foreach ($sGroups as $gData) {
            if ($gData['id']['language'] == 'ro' && $gData['group_name'] == 'META') {
                try {
                $sQuestions = \Yii::$app->survey->listQuestions($surveyId, $gData['id']['gid']);
                } catch (LimeSurveyException $e) {
                \Yii::$app->getSession()->setFlash('error', $e->getMessage()); 
                }      
                if ($sQuestions == null || isset($sQuestions['status'])) $sQuestions = [];
                foreach ($sQuestions as $qData) {
                    switch ($qData['title']) {
                        case 'FACULTATEA':
                            $nonCorrespondence['FACULTATEA'] = $this->checkNonCorrespondence(
                                $qData['id']['qid'],
                                Faculty::find()->orderBy(['id' => SORT_ASC])->all(),
                                function ($model) {
                                    return $model->name;
                                }
                            );
                            break;
                        case 'CICLUL':
                            $nonCorrespondence['CICLUL'] = $this->checkNonCorrespondence(
                                $qData['id']['qid'],
                                StudyCycle::find()->orderBy(['id' => SORT_ASC])->all(),
                                function ($model) {
                                    return $model->name;
                                }
                            );
                            break;
                        case 'SPECIALITATEA':
                            $nonCorrespondence['SPECIALITATEA'] = $this->checkNonCorrespondence(
                                $qData['id']['qid'],
                                Specialty::find()->orderBy(['id' => SORT_ASC])->all(),
                                function ($model) {
                                    return $model->name;
                                }
                            );
                            break;
                        case 'GRUPA':
                            $nonCorrespondence['GRUPA'] = $this->checkNonCorrespondence(
                                $qData['id']['qid'],
                                Group::find()->orderBy(['id' => SORT_ASC])->all(),
                                function ($model) {
                                    return $model->name;
                                }
                            );
                            break;
                        case 'DISCIPLINA':
                            $nonCorrespondence['DISCIPLINA'] = $this->checkNonCorrespondence(
                                $qData['id']['qid'],
                                Course::find()->orderBy(['id' => SORT_ASC])->all(),
                                function ($model) {
                                    return $model->name;
                                }
                            );
                            break;
                        case 'ACTIVITATEA':
                            $nonCorrespondence['ACTIVITATEA'] = $this->checkNonCorrespondence(
                                $qData['id']['qid'],
                                ActivityType::find()->orderBy(['id' => SORT_ASC])->all(),
                                function ($model) {
                                    return $model->name;
                                }
                            );
                            break;
                        case 'PROFESORUL':
                            $nonCorrespondence['PROFESORUL'] = $this->checkNonCorrespondence(
                                $qData['id']['qid'],
                                Instructor::find()->orderBy(['id' => SORT_ASC])->all(),
                                function ($model) {
                                    return $model->full_name;
                                }
                            );
                            break;
                    }
                }
            }
        }

        // summary
        $summary = null;
        if ($active) {
            $command = \Yii::$app->getDb()->createCommand('SELECT ROUND(AVG(cnt)) AS avg FROM (SELECT COUNT(*) AS cnt FROM group_activity WHERE semester_id=1 GROUP BY group_id) AS cnts');
            $rows = $command->queryAll();

            $summary = \Yii::$app->survey->getSummary($surveyId);
            if (!empty($rows[0]['avg']))
                $summary['students'] = round($summary['full_responses'] / $rows[0]['avg']);
            else
                $summary['students'] = 0;
        }

        //\Yii::$app->getSession()->setFlash('error', 'Your Text Here..');

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
        foreach ($models as $model) {
            if (!isset($props['answeroptions'][$model->id]) || strtolower($modelNameFunc($model)) !== strtolower($props['answeroptions'][$model->id]['answer'])) {
                $result[] = ['code' => $model->id, 'answer' => $modelNameFunc($model)];
            }
        }

        return $result;
    }
}
