<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StudyCycle */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Study Cycle',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Study Cycles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-cycle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
