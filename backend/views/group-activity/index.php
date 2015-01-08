<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GroupActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Group Activities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-activity-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Group Activity',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'group', 'value' => 'group.name'],
            ['attribute' => 'activityType', 'value' => 'activityType.name'],
            ['attribute' => 'course', 'value' => 'course.name'],
            ['attribute' => 'instructor', 'value' => 'instructor.last_name'],
            ['attribute' => 'semester', 'value' => 'semester.name'],
            // 'subgroup',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
