<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\models\GroupActivity;
use common\models\ActivityType;
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
            'specialty.name',
            'studyForm.name',
        ],
    ]) ?>

<?php
    $GLOBALS['actvityTypes'] = ActivityType::find()->orderBy(['id' => SORT_ASC])->all();
    $groupActivities = GroupActivity::find()
        ->joinWith(['course'])
        ->where(['group_id' => $model->id])
        ->orderBy(['course.name' => SORT_ASC,])
        ->all();

    $groupActivities2 = [];
    foreach($groupActivities as $ga)
    {
        if(!isset($groupActivities2[$ga->course_id]))
            $groupActivities2[$ga->course_id] = ['course' => ['name' => $ga->course->name, 'id' => $ga->course->id], 'group' => ['id' => $model->id], 'semester' => ['id' => 2]];
        if(!isset($groupActivities2[$ga->course_id]['activities']))
            $groupActivities2[$ga->course_id]['activities'] = [];            
        if(!isset($groupActivities2[$ga->course_id]['activities'][$ga->activity_type_id]))
            $groupActivities2[$ga->course_id]['activities'][$ga->activity_type_id] = [];
        $groupActivities2[$ga->course_id]['activities'][$ga->activity_type_id][$ga->instructor->id] = $ga->instructor->last_name . ' ' . $ga->instructor->first_name;
    }
?>



<?php
$dataProvider = new ArrayDataProvider([
    'allModels' => $groupActivities2,
    'pagination' => false,
]); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        
        ['attribute' => 'course', 'value' => 'course.name'],
        ['attribute' => 'Prelegeri', 'value' => function($model) {$s='';if(!isset($model['activities'][$GLOBALS['actvityTypes'][0]->id])) return NULL;foreach($model['activities'][$GLOBALS['actvityTypes'][0]->id] as $ii=>$in) $s.=$in.';'; return $s;}],
        ['attribute' => 'Seminare', 'value' => function($model) {$s='';if(!isset($model['activities'][$GLOBALS['actvityTypes'][1]->id])) return NULL;foreach($model['activities'][$GLOBALS['actvityTypes'][1]->id] as $ii=>$in) $s.=$in.';'; return $s;}],
        ['attribute' => 'Laborator', 'value' => function($model) {$s='';if(!isset($model['activities'][$GLOBALS['actvityTypes'][2]->id])) return NULL;foreach($model['activities'][$GLOBALS['actvityTypes'][2]->id] as $ii=>$in) $s.=$in.';'; return $s;}],
        
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
