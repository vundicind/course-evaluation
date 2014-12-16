<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Specialty */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Specialty',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Specialties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specialty-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
