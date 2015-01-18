<p><?= $courseName ?></p>
<p><?= $instructorFullName ?></p>
<p><?= $activityTypeName . '(' . $activityTypeId .')' ?></p>

<?php
if($subgroup):
?>
<script>
if (confirm('Are you sure you want to save this thing into the database?')) {
    
} else {
    
}
</script>
<?php endif; ?>

<?= \frontend\widgets\EmbedSurvey::widget([
    'src' => 'http://elearning.usarb.md/dmc/limesurvey',
    'surveyId' => '429785',
    'lang' => 'ro',
    'params' => [
        'FACULTATEA' => '3',
        'CICLUL' => '1',
        'SPECIALITATEA' => '62',
        'GRUPA' => '90',
        'DISCIPLINA' => '5',
        'ACTIVITATEA' => '1',
        'PROFESORUL' => '199',
    ]
]); ?>

