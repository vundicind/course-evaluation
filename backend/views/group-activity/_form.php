<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Group;
use common\models\ActivityType;
use common\models\Course;
use common\models\Instructor;
use common\models\Semester;
use common\models\GroupActivity;

/* @var $this yii\web\View */
/* @var $model app\models\GroupActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-activity-form">

<?php
$group_id = 1;
$course_id = 3;

    $actvityTypes = ActivityType::find()->orderBy(['id' => SORT_ASC])->all();

    $groupActivities = GroupActivity::find()
        ->where(['group_id' => $group_id, 'course_id' => $course_id])
        ->all();

    $groupActivities2 = [];
    foreach($groupActivities as $ga)
    {
        if(!isset($groupActivities2[$ga->course_id]))
            $groupActivities2[$ga->course_id] = ['course' => ['name' => $ga->course->name, 'id' => $ga->course->id]];
        if(!isset($groupActivities2[$ga->course_id]['activities']))
            $groupActivities2[$ga->course_id]['activities'] = [];            
        if(!isset($groupActivities2[$ga->course_id]['activities'][$ga->activity_type_id]))
            $groupActivities2[$ga->course_id]['activities'][$ga->activity_type_id] = [];
        $groupActivities2[$ga->course_id]['activities'][$ga->activity_type_id][$ga->instructor->id] = $ga->instructor->last_name . ' ' . $ga->instructor->first_name;
    }

?>

Course name: <?= $groupActivities2[$course_id]['course']['name'] ?><br />
<?= $actvityTypes[0]->name ?>: 
<?= $actvityTypes[1]->name ?>: <br />
<?= $actvityTypes[2]->name ?>: <br />

<hr />

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(Group::find()->asArray()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Select Group')]) ?>

    <?= $form->field($model, 'course_id')->dropDownList(ArrayHelper::map(Course::find()->asArray()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Select Course')]) ?>

    <?= $form->field($model, 'instructor_id')->dropDownList(ArrayHelper::map(Instructor::find()->asArray()->all(), 'id', function ($element) { return $element['first_name'] . ' ' . $element['last_name'];}), ['prompt' => Yii::t('app', 'Select Instructor')]) ?>
    
    <?= $form->field($model, 'activity_type_id')->dropDownList(ArrayHelper::map(ActivityType::find()->asArray()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Select Activity Type')]) ?>
    
    <?= $form->field($model, 'semester_id')->dropDownList(ArrayHelper::map(Semester::find()->asArray()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Select Semester')]) ?>
    
    <?= $form->field($model, 'subgroup')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
