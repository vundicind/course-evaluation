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
        \Yii::$app->session->set('survey.groupCourses', null);   
    
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
        
        $groupCourses = \Yii::$app->session->get('survey.groupCourses');
        $course_id = \Yii::$app->session->get('survey.course_id');
        $instructor_id = \Yii::$app->session->get('survey.instructor_id');
        $activity_id = \Yii::$app->session->get('survey.activity_id');                        
$gc = [];
        if($groupCourses == null)
    	{
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
						    'instructors' => [],
				    ];
				
			    if(!isset($groupCourses[$ga->course_id]['instructors'][$ga->instructor_id]))
        			$groupCourses[$ga->course_id]['instructors'][$ga->instructor_id] = [
        			    'instructor' => [
        			        'fullName' => $ga->instructor->full_name, 
        			        'id' => $ga->instructor_id
        			    ],
        			    'activities' => [],
        			];
        			
                $groupCourses[$ga->course_id]['instructors'][$ga->instructor_id]['activities'][$ga->id] = [
                    'activity' => [
                        'id' => $ga->id,
                        'name' => $ga->activityType->name,
                        'subgroup' => $ga->subgroup,
                    ],
                ];
		    }
		    
        }
 
		return $this->render('survey', [
		    'groupCourses' => $groupCourses, 
		    'course' => $course_id, 
		    'instructor_id' => $instructor_id, 
		    'activity_id' => $activity_id
	    ]);
    }        
}
