<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StudyForm */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Study Form',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Study Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-form-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
