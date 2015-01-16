<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            ['label' => Yii::t('app', 'Specialty'), 'value' => $model->specialty->name],            
            ['label' => Yii::t('app', 'Study form'), 'value' => $model->studyForm->name],
        ],
    ]) ?>
    
    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Group Activity',
]), ['group-activity/create', 'group_id' => $model->id, 'semester_id' => $semester_id], ['class' => 'btn btn-success']) ?>
    </p>
<?php 
	$GLOBALS['activityTypes'] = $activityTypes;//!!! 
?>    
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        
        ['attribute' => 'course', 'value' => 'course.name'],
        [
        		'attribute' => $activityTypes[0]->name,
        		'format' => 'html',
        		'value' => function($model) use ($activityTypes) {$s='';if(!isset($model['activities'][$activityTypes[0]->id])) return NULL;foreach($model['activities'][$activityTypes[0]->id] as $ii=>$in) $s.=$in.'<br />'; return $s;}
        ],
        [
        		'attribute' => $activityTypes[1]->name,
        		'format' => 'html',
        		'value' => function($model) use ($activityTypes) {$s='';if(!isset($model['activities'][$activityTypes[1]->id])) return NULL;foreach($model['activities'][$activityTypes[1]->id] as $ii=>$in) $s.=$in.'<br />'; return $s;}
        ],
        [
        		'attribute' => $activityTypes[2]->name, 
        		'format' => 'html',
        		'value' => function($model) use ($activityTypes) {$s='';if(!isset($model['activities'][$activityTypes[2]->id])) return NULL;foreach($model['activities'][$activityTypes[2]->id] as $ii=>$in) $s.=$in.'<br />'; return $s;}
        ],
        
        [
        	'class' => 'yii\grid\ActionColumn',
        	'template' => '{update} {delete}',	
        	'buttons' => [
        		'update' => function ($url, $model, $key) {
        				$url = Url::toRoute(['/group-activity/update', 'course_id' => $model['course']['id'], 'group_id' => $model['group']['id'], 'semester_id' => $model['semester']['id']]); 
                		return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    		'title' => Yii::t('yii', 'Update'),
                    		'data-pjax' => '0',
                		]);
        			},
        		'delete' => function ($url, $model, $key) {
        				$url = Url::toRoute(['/group-activity/delete', 'course_id' => $model['course']['id'], 'group_id' => $model['group']['id'], 'semester_id' => $model['semester']['id']]);
                		return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    		'title' => Yii::t('yii', 'Delete'),
                    		'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    		'data-method' => 'post',
                    		'data-pjax' => '0',
                		]);
        			} 			
        	]	
        ],
    ]
]);?>
    
</div>
