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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GroupActivity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GroupActivity();
        
        $group = new Group;
        $course = new Course;
        $semester = new Semester;

//        $modelsActivity = [GroupActivity::find()->where(['course_id' => 3, 'group_id' => 1])->one()];
                        
        $modelsActivity = [new GroupActivity];        

        if ($model->load(Yii::$app->request->post())) {

$modelsActivity = $this->createMultiple(GroupActivity::classname());
Model::loadMultiple($modelsActivity, Yii::$app->request->post());
        

if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validateMultiple($modelsActivity);
}
foreach($modelsActivity as $modelActivity)
{
$modelActivity->course_id=$course_id;
$modelActivity->group_id=$group_id;
$modelActivity->semester_id=$semester_id;
}        

// validate all models
$valid = $model->validate();

$valid = Model::validateMultiple($modelsActivity) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            GroupActivity::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsActivity as $modelActivity) {
                            $modelActivity->course_id = $course_id;
                            $modelActivity->group_id = $group_id;
                            $modelActivity->semester_id = $semester_id;                            
                            if (! ($flag = $modelActivity->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

        
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model, 'modelsActivity' => (empty($modelsActivity)) ? [new GroupActivity] : $modelsActivity,
                'group' => $group, 'course' => $course, 'semester' => $semester,
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
$group=Group::findOne($group_id);
$course=Course::findOne($course_id);
$semester=Semester::findOne($semester_id);

$modelsActivity = GroupActivity::find()->where(['course_id' => $course_id, 'group_id' => $group_id])->all();
$model = $modelsActivity[0];

        if ($model->load(Yii::$app->request->post())) {
$oldIDs = ArrayHelper::map($modelsActivity, 'id', 'id');        
//$modelsActivity = Model::createMultiple(GroupActivity::classname(), $modelsActivity);
$modelsActivity = $this->createMultiple(GroupActivity::classname(), $modelsActivity);

Model::loadMultiple($modelsActivity, Yii::$app->request->post());
$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsActivity, 'id', 'id')));

// ajax validation
if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validateMultiple($modelsActivity);
}
foreach($modelsActivity as $modelActivity)
{
$modelActivity->course_id=$course_id;
$modelActivity->group_id=$group_id;
$modelActivity->semester_id=$semester_id;
}        

// validate all models
$valid = $model->validate();

$valid = Model::validateMultiple($modelsActivity) && $valid;
//foreach($modelsActivity as $modelActivity) print_r($modelActivity->errors);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            GroupActivity::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsActivity as $modelActivity) {
                            $modelActivity->course_id = $course_id;
                            $modelActivity->group_id = $group_id;
                            $modelActivity->semester_id = $semester_id;                            
                            if (! ($flag = $modelActivity->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

                    
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model, 'modelsActivity' => (empty($modelsActivity)) ? [new GroupActivity] : $modelsActivity,
                'group' => $group, 'course' => $course, 'semester' => $semester,
            ]);
        }
    }

    /**
     * Deletes an existing GroupActivity model.
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
