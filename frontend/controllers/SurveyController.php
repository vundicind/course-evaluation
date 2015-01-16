<?php

namespace frontend\controllers;

use common\models\Faculty;
use common\models\StudyCycle;
use common\models\StudyForm;
use common\models\Specialty;
use common\models\Group;
use common\models\GroupActivity;

class SurveyController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $items = [];
        
        $groups = Group::find()
            ->joinWith(['specialty'])
            ->orderBy(['specialty.faculty_id' => SORT_ASC, 'specialty_id' => SORT_ASC, 'name' => SORT_ASC])
            ->all();    
            
        $i = null; $iid = null;
        $j = null; $jid = null;   
        foreach($groups as $group)
        {
            if($i === null || ($iid !== null && $iid !== $group->specialty->faculty_id))
            {
                $items[] = ['label' => $group->specialty->faculty->name, 'items' => []];
                $i = ($i === null) ? 0 : $i+1; $iid = $group->specialty->faculty_id;
                $j = null;
            }    

            if($j === null || ($jid !== null && $jid !== $group->specialty_id))
            {
                $items[$i]['items'][] = ['label' => $group->specialty->name, 'items' => []];
                $j = ($j === null) ? 0 : $j+1; $jid = $group->specialty_id;
            }    
                 
            $items[$i]['items'][$j]['items'][] = ['label' => $group->name, 'url' => ['survey/survey', 'group_id' => $group->id]];
        }    

        return $this->render('index', ['items' => $items]);
    }
}
