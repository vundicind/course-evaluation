<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GroupActivitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-activity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'group_id') ?>

    <?= $form->field($model, 'activity_type_id') ?>

    <?= $form->field($model, 'course_id') ?>

    <?= $form->field($model, 'instructor_id') ?>

    <?php // echo $form->field($model, 'semester_id') ?>

    <?php // echo $form->field($model, 'subgroup') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
