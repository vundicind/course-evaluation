<?php

namespace frontend\controllers;

use common\models\Faculty;
use common\models\StudyCycle;
use common\models\StudyForm;
use common\models\Specialty;
use common\models\Group;
use common\models\GroupActivity;
use common\models\ActivityType;

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
    
    public function actionSurvey($group_id)
    {
        $semester_id = 1;//!!!
    	$activityTypes = ActivityType::find()->orderBy(['id' => SORT_ASC])->all();    	
    	
    	$groupActivities = GroupActivity::find()//!!!This block should be moved to another action e.g. 'actionCourse'
    		->joinWith(['course', 'instructor'])
    		->where(['group_id' => $group_id, 'semester_id' => $semester_id])
    		->orderBy(['course.name' => SORT_ASC, 'instructor.last_name' => SORT_ASC, 'instructor.first_name' => SORT_ASC])
    		->all();
    	 
		$groupCourses = [];
		foreach($groupActivities as $ga)
		{
			if(!isset($groupCourses[$ga->course_id]))
				$groupCourses[$ga->course_id] = [
						'course' => [
								'name' => $ga->course->name,
								'id' => $ga->course->id
						],
						'group' => [
								'id' => $group_id
						],
						'semester' => [
								'id' => $semester_id
						],
				];
				
			if(!isset($groupCourses[$ga->course_id]['activities']))
				$groupCourses[$ga->course_id]['activities'] = [];
				
			if(!isset($groupCourses[$ga->course_id]['activities'][$ga->activity_type_id]))
				$groupCourses[$ga->course_id]['activities'][$ga->activity_type_id] = [];
				
			$groupCourses[$ga->course_id]['activities'][$ga->activity_type_id][$ga->instructor->id] = $ga->instructor->full_name;
		}
		
		return $this->render('survey', ['groupCourses' => $groupCourses]);
    }        
}
