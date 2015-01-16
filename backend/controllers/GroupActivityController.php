<?php

namespace backend\controllers;

use Yii;
use common\models\GroupActivity;
use backend\models\GroupActivitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use common\models\Group;
use common\models\Course;
use common\models\Semester;
use common\models\CourseGroup;

/**
 * GroupActivityController implements the CRUD actions for GroupActivity model.
 */
class GroupActivityController extends Controller
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
     * Lists all GroupActivity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupActivitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GroupActivity model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($course_id, $group_id, $semester_id)
    {
        //return $this->render('view', [
        //    'model' => $this->findModel($id),
        //]);
    }

    /**
     * Creates a new GroupActivity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new CourseGroup;
    	$model->group_id = isset($_GET['group_id']) ? $_GET['group_id'] : null; 
    	$model->semester_id = isset($_GET['semester_id']) ? $_GET['semester_id'] : null;
    	
        $modelsActivity = [new GroupActivity];        

        if ($model->load(Yii::$app->request->post())) {
			$modelsActivity = $this->createMultiple(GroupActivity::classname());
			Model::loadMultiple($modelsActivity, Yii::$app->request->post());

			foreach($modelsActivity as $modelActivity)
			{
				$modelActivity->course_id = $model->course_id;
				$modelActivity->group_id = $model->group_id;
				$modelActivity->semester_id = $model->semester_id;
			}
				
			if (Yii::$app->request->isAjax) {
				Yii::$app->response->format = Response::FORMAT_JSON;
				return ArrayHelper::merge(
						ActiveForm::validateMultiple($modelsActivity),
						ActiveForm::validate($model)
				);				
			}

			// validate all models
			$valid = $model->validate();
			$valid = Model::validateMultiple($modelsActivity) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                	$flag = true;
                    //if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            GroupActivity::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsActivity as $modelActivity) {
                            if (! ($flag = $modelActivity->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    //}
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['group/view', 'id' => $model->group_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

        
            return $this->redirect(['group/view', 'id' => $model->group_id]);
        } else {
            return $this->render('create', [
                'model' => $model, 
            	'modelsActivity' => (empty($modelsActivity)) ? [new GroupActivity] : $modelsActivity,
            ]);
        }
    }

    /**
     * Updates an existing GroupActivity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($course_id, $group_id, $semester_id)
    {
    	
    	$model = new CourseGroup;
    	$model->group_id = $group_id;
    	$model->course_id = $course_id;
    	$model->semester_id = $semester_id;
    	
		$modelsActivity = GroupActivity::find()
			->joinWith(['instructor'])
			->where(['course_id' => $course_id, 'group_id' => $group_id, 'semester_id' => $semester_id])
			->orderBy(['activity_type_id' => SORT_ASC, 'instructor.last_name' => SORT_ASC, 'instructor.first_name' => SORT_ASC])
			->all();

        if ($model->load(Yii::$app->request->post())) {
			$oldIDs = ArrayHelper::map($modelsActivity, 'id', 'id');        
			$modelsActivity = $this->createMultiple(GroupActivity::classname(), $modelsActivity);
			Model::loadMultiple($modelsActivity, Yii::$app->request->post());
			$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsActivity, 'id', 'id')));

			foreach($modelsActivity as $modelActivity)
			{
				$modelActivity->course_id=$model->course_id;
				$modelActivity->group_id=$model->group_id;
				$modelActivity->semester_id=$model->semester_id;
			}
				
			// ajax validation
			if (Yii::$app->request->isAjax) {
				Yii::$app->response->format = Response::FORMAT_JSON;
				return ArrayHelper::merge(
						ActiveForm::validateMultiple($modelsActivity),
						ActiveForm::validate($model)
				);				
			}
			
			// validate all models
			$valid = $model->validate();
			$valid = Model::validateMultiple($modelsActivity) && $valid;
			//foreach($modelsActivity as $modelActivity) print_r($modelActivity->errors);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                	$flag = true;
                    //if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            GroupActivity::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsActivity as $modelActivity) {
                            if (! ($flag = $modelActivity->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    //}
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['group/view', 'id' => $model->group_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

                    
            return $this->redirect(['group/view', 'id' => $model->group_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            	'modelsActivity' => (empty($modelsActivity)) ? [new GroupActivity] : $modelsActivity,
            ]);
        }
    }

    /**
     * Deletes an existing GroupActivity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($course_id, $group_id, $semester_id)
    {
        //$this->findModel($id)->delete();//-RD
        $modelsActivity = GroupActivity::find()->where(['course_id' => $course_id, 'group_id' => $group_id, 'semester_id' => $semester_id])->all();
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            foreach($modelsActivity as $modelActivity) 
            {
                $modelActivity->delete();
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack(); 
        }    

        $this->redirect(['group/view', 'id' => $group_id]);       
    }

    /**
     * Finds the GroupActivity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GroupActivity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GroupActivity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
   public function createMultiple($modelClass, $multipleModels=null)
    {
        $model    = new $modelClass;
        $formName = $model->formName();//GroupActivity
        $post     = Yii::$app->request->post($formName);
        $models   = [];
        $flag     = false;

        if ($multipleModels !== null && is_array($multipleModels) && !empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
            $flag = true;
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if ($flag) {
                    if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                        $models[] = $multipleModels[$item['id']];
                    } else {
                        $models[] = new $modelClass;
                    }
                } else {
                    $models[] = new $modelClass;
                }
            }
        }
        unset($model, $formName, $post);
        return $models;
    }     
}
