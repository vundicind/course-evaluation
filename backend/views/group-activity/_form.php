<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Group;
use app\models\ActivityType;
use app\models\Course;
use app\models\Instructor;
use app\models\Semester;

/* @var $this yii\web\View */
/* @var $model app\models\GroupActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(Group::find()->asArray()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Select Group')]) ?>

    <?= $form->field($model, 'activity_type_id')->dropDownList(ArrayHelper::map(ActivityType::find()->asArray()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Select Activity Type')]) ?>

    <?= $form->field($model, 'course_id')->dropDownList(ArrayHelper::map(Course::find()->asArray()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Select Course')]) ?>

    <?= $form->field($model, 'instructor_id')->dropDownList(ArrayHelper::map(Instructor::find()->asArray()->all(), 'id', function ($element) { return $element['first_name'] . ' ' . $element['last_name'];}), ['prompt' => Yii::t('app', 'Select Instructor')]) ?>
    
    <?= $form->field($model, 'semester_id')->dropDownList(ArrayHelper::map(Semester::find()->asArray()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Select Semester')]) ?>
    
    <?= $form->field($model, 'subgroup')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
