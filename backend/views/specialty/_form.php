<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Faculty;
use app\models\StudyCycle;

/* @var $this yii\web\View */
/* @var $model app\models\Specialty */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="specialty-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'faculty_id')->dropDownList(ArrayHelper::map(Faculty::find()->asArray()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'study_cycle_id')->dropDownList(ArrayHelper::map(StudyCycle::find()->asArray()->all(), 'id', 'name')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
