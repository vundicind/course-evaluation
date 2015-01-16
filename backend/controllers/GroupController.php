<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\models\Group;
use backend\models\GroupSearch;
use common\models\GroupActivity;
use common\models\ActivityType;


/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);//+RD20140116
    	$semester_id = 1;//!!!
    	
    	$activityTypes = ActivityType::find()->orderBy(['id' => SORT_ASC])->all();    	
    	
    	$groupActivities = GroupActivity::find()//!!!This block should be moved to another action e.g. 'actionCourse'
    		->joinWith(['course', 'instructor'])
    		->where(['group_id' => $model->id, 'semester_id' => $semester_id])
    		->orderBy(['course.name' => SORT_ASC, 'instructor.last_name' => SORT_ASC, 'instructor.first_name' => SORT_ASC])
    		->all();
    	 
		$groupCourses = [];
		foreach($groupActivities as $ga)
		{
			if(!isset($groupCourses[$ga->course_id]))
				$groupCourses[$ga->course_id] = [
						'course' => [
								'name' => $ga->course->name,
								'id' => $ga->course->id
						],
						'group' => [
								'id' => $model->id
						],
						'semester' => [
								'id' => $semester_id
						],
				];
				
				if(!isset($groupCourses[$ga->course_id]['activities']))
					$groupCourses[$ga->course_id]['activities'] = [];
				
				if(!isset($groupCourses[$ga->course_id]['activities'][$ga->activity_type_id]))
					$groupCourses[$ga->course_id]['activities'][$ga->activity_type_id] = [];
				
				$groupCourses[$ga->course_id]['activities'][$ga->activity_type_id][$ga->instructor->id] = $ga->instructor->full_name . (($ga->subgroup==1)?' (' . Yii::t('app', 'Subgroup') . ')':'');
		}
		
		$dataProvider = new ArrayDataProvider([
			'allModels' => $groupCourses,
			'pagination' => false,
		]);
				
    	
        return $this->render('view', [
            //'model' => $this->findModel($id),//-RD20140116
        	'model' => $model,//+RD20140116
        	'semester_id' => $semester_id,
        	'activityTypes' => $activityTypes,
        	'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Group();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Group model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
