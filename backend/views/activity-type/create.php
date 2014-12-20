<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ActivityType */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Activity Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Activity Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
