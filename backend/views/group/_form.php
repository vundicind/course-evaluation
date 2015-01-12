<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Specialty;
use common\models\StudyForm;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'specialty_id')->dropDownList(ArrayHelper::map(Specialty::find()->asArray()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Select Specialty')]) ?>
    
    <?= $form->field($model, 'study_form_id')->dropDownList(ArrayHelper::map(StudyForm::find()->asArray()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Select Study Form')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
