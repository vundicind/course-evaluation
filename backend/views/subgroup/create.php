<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Subgroup */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Subgroup',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subgroups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subgroup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
