<center>
	<h1><?= $group->name ?></h1>
</center>

<?php
if($subgroup && !isset($_GET['subgroup'])):
?>

<div class="alert alert-warning" role="alert">
  <p>Ați avut ore de <b><?= $activityType->name ?></b> la <b><?= $course->name ?></b> cu <b><?= $instructor->full_name?></b>?</p>
  <p>
  <a class="btn btn-default" href="<?= yii\helpers\Url::to(['survey/survey', 'group_id' => $group->id, 'subgroup' => 1]) ?>" role="button">Da</a>
  <a class="btn btn-default" href="<?= yii\helpers\Url::to(['survey/submit', 'iframe' => false]) ?>" role="button">Nu</a>
  </p>
</div>

<?php else: ?>

<?= \frontend\widgets\EmbedSurvey::widget([
    'src' => 'http://elearning.usarb.md/dmc/limesurvey',
    'surveyId' => '429785',
    'lang' => 'ro',
    'params' => [
        'FACULTATEA' => $group->specialty->faculty_id,
        'CICLUL' => $group->specialty->study_cycle_id,
        'SPECIALITATEA' => $group->specialty->id,
        'GRUPA' => $group->id,
        'DISCIPLINA' => $course->id,
        'ACTIVITATEA' => (empty($activityType)?'4':$activityType->id),
        'PROFESORUL' => $instructor->id,
    ]
]); ?>

<?php endif; ?>
