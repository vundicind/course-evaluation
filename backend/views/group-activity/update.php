<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GroupActivity */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Group Activity',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Group Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="group-activity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
