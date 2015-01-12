<?php
/* @var $this yii\web\View */
?>
<h1>survey/index</h1>

<?php
if(!empty($faculties))
{	
	foreach($faculties as $f)
		echo yii\helpers\Html::a($f->name, ['index', 'f' => $f->id]) . '<br />';
}
?>

<?php
if(!empty($studyCycles))
{	
	foreach($studyCycles as $sc)
		echo yii\helpers\Html::a($sc->name, ['index', 'sc' => $sc->id, 'f' => $f]) . '<br />';
}
?>

<?php
if(!empty($studyForms))
{	
	foreach($studyForms as $sf)
		echo yii\helpers\Html::a($sf->name, ['index', 'sf' => $sf->id, 'f' => $f, 'sc' => $sc]) . '<br />';
}
?>

<?php
if(!empty($specialties))
{	
	foreach($specialties as $s)
		echo yii\helpers\Html::a($s->name, ['index', 's' => $s->id]) . '<br />';
}
?>

<?php
if(!empty($groups))
{	
	foreach($groups as $g)
		echo yii\helpers\Html::a($g->name, ['index', 'g' => $g->id]) . '<br />';
}
?>