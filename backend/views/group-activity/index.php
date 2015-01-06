<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Group Activities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-activity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Group Activity',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'group_id',
            'activity_type_id',
            'course_id',
            'instructor_id',
            'semester_id',
            // 'subgroup',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
