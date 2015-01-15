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
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\GroupActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-activity-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($group, 'id')->widget(Select2::classname(), [
    'data' => array_merge(["" => ""], ArrayHelper::map(Group::find()->asArray()->all(), 'id', 'name')),
    'options' => ['placeholder' => Yii::t('app', 'Select Group')],
    'pluginOptions' => [
        'allowClear' => false
    ],
]); ?>

    <?= $form->field($course, 'id')->
widget(Select2::classname(), [
    'data' => array_merge(["" => ""], ArrayHelper::map(Course::find()->asArray()->all(), 'id', 'name')),
    'options' => ['placeholder' => Yii::t('app', 'Select Course')],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

    <?= $form->field($semester, 'id')->
widget(Select2::classname(), [
    'data' => array_merge(["" => ""], ArrayHelper::map(Semester::find()->asArray()->all(), 'id', 'name')),
    'options' => ['placeholder' => Yii::t('app', 'Select Semester')],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
    
    
<div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Activities</h4></div>
        <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'dynamicItems' => '#form-activities',
                'dynamicItem' => '.form-activities-item',
                'model' => $modelsActivity[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'activity_type_id',
                    'instructor_id',
                    'subgroup',
                ],
                'options' => [
                    'min' => 1,
                    'limit' => 9, // the maximum times, an element can be cloned (default 999)
                ]
            ]); ?> 

            <div id="form-activities">
            <?php foreach ($modelsActivity as $i => $modelActivity): ?>
                <div class="form-activities-item panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Activity</h3>
                        <div class="pull-right">
                            <button type="button" class="clone btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="delete btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelActivity->isNewRecord) {
                                echo Html::activeHiddenInput($modelActivity, "[{$i}]id");
                            }
                        ?>
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelActivity, "[{$i}]activity_type_id")->
widget(Select2::classname(), [
    'data' => array_merge(["" => ""], ArrayHelper::map(ActivityType::find()->asArray()->all(), 'id', 'name')),
    'options' => ['placeholder' => Yii::t('app', 'Select Activity Type')],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelActivity, "[{$i}]instructor_id")->
widget(Select2::classname(), [
    'data' => array_merge(["" => ""], ArrayHelper::map(Instructor::find()->asArray()->all(), 'id', function($e) {return $e['last_name'] . ' ' . $e['first_name'];})),
    'options' => ['placeholder' => Yii::t('app', 'Select Instructor')],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelActivity, "[{$i}]subgroup")->textInput() ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
