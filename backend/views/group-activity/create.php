<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GroupActivity */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Group Activity',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Group Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-activity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
