<p><?= $courseName ?></p>
<p><?= $instructorFullName ?></p>
<p><?= $activityTypeName . '(' . $activityTypeId .')' ?></p>

<?php
    \Yii::$app->session->set('survey.groupActivitiesIndex', $groupActivitiesIndex);
?>


