<?php

namespace frontend\controllers;

use yii\helpers\Url;
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
    	$surveyId = \Yii::$app->survey->surveyId;
    	$sp = \Yii::$app->survey->getSurveyProperties($surveyId, ['sid', 'active', 'expires']);
    	if(isset($sp['active']) && $sp['active'] == 'Y' && empty($sp['expires']))
    		$active = true;
    	else
    		$active = false;
    		
        \Yii::$app->session->set('survey.groupActivities', null);
    
        $items = [];
        
        $groups = Group::find()
            ->joinWith(['specialty'])
            ->orderBy(['specialty.faculty_id' => SORT_ASC, 'specialty_id' => SORT_ASC, 'study_form_id' => SORT_ASC, 'name' => SORT_ASC])
            ->all();    
            
        $i = null; $iid = null;
        $j = null; $jid = null;   
        $k = null; $kid = null;        
        foreach($groups as $group)
        {
            if($i === null || ($iid !== null && $iid !== $group->specialty->faculty_id))
            {
                $items[] = ['label' => $group->specialty->faculty->name, 'items' => []];
                $i = ($i === null) ? 0 : $i+1; $iid = $group->specialty->faculty_id;
                $j = null;
                $k = null;
            }    

            if($j === null || ($jid !== null && $jid !== $group->specialty_id))
            {
                $items[$i]['items'][] = ['label' => $group->specialty->name, 'items' => []];
                $j = ($j === null) ? 0 : $j+1; $jid = $group->specialty_id;
                $k = null;
            }    

            if($k === null || ($kid !== null && $kid !== $group->study_form_id))
            {
            	$items[$i]['items'][$j]['items'][] = ['label' => $group->studyForm->name, 'items' => []];
            	$k = ($k === null) ? 0 : $k+1; $kid = $group->study_form_id;
            }
            
            //$items[$i]['items'][$j]['items'][] = ['label' => $group->name, 'url' => ['survey/survey', 'group_id' => $group->id]];
            $items[$i]['items'][$j]['items'][$k]['items'][] = ['label' => $group->name, 'url' => ['survey/survey', 'group_id' => $group->id]];
        }    

        return $this->render('index', ['items' => $items, 'active' => $active]);
    }
    
    public function actionSurvey($group_id)
    {
        \Yii::$app->session->set('survey.groupId', $group_id);
    
        //$semester_id = 2;//!!!
	$semester_id = \Yii::$app->settings->get('app.semesterId', 'App');
        
        $groupActivities = \Yii::$app->session->get('survey.groupActivities');
        $groupActivitiesIndex = \Yii::$app->session->get('survey.groupActivitiesIndex');

        if($groupActivities == null)
    	{
    	    $groupActivitiesIndex = 0;
    	    \Yii::$app->session->set('survey.groupActivitiesIndex', $groupActivitiesIndex);
    	    
    	    $p = ActivityType::find()->orderBy(['id' => SORT_ASC])->one()->id;

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
        			
                $groupCourses[$ga->course_id]['instructors'][$ga->instructor_id]['activities'][$ga->activity_type_id] = [
                    'activity' => [
                        'id' => $ga->id,
                        'activity_type_id' => $ga->activity_type_id,                        
                        'name' => $ga->activityType->name,
                        'subgroup' => $ga->subgroup,
                    ],
                ];
		    }
		    
		    $groupActivities = [];
            foreach($groupCourses as $course)
            {
                foreach($course['instructors'] as $iid => $instructor)
                {
                    if(count($instructor['activities']) >= 2)
                    {
                        if(array_key_exists($p, $instructor['activities']) && !$instructor['activities'][$p]['activity']['subgroup'])
                        {
                        	$sb = false;
                        	foreach($instructor['activities'] as $aaa => $bbb)
                        	{
                        		if($bbb['activity']['subgroup'])
                        			$sb = true;	
                        	}
                        	
                        	if(!$sb) {
                            	$groupActivities[] = [
                                	'course_id' => $course['course']['id'],
	                                'group_id' => $group_id,
    	                            'instructor_id' => $instructor['instructor']['id'],
        	                        'activity_type_id' => 0,
            	                    'subgroup' => false,
                	            ];
                    	        continue;
                        	}
                        }
                    }    
            
                    foreach($instructor['activities'] as $aid => $activity)
                    {
                            $groupActivities[] = [
                                'course_id' => $course['course']['id'],
                                'group_id' => $group_id,
                                'instructor_id' => $instructor['instructor']['id'],
                                'activity_type_id' => $activity['activity']['activity_type_id'],
                                'subgroup' => $activity['activity']['subgroup'],                                
                            ];
                    }
                }        
            }		    
		
		    \Yii::$app->session->set('survey.groupActivities', $groupActivities);    
        }
        
        if($groupActivitiesIndex === null)
            $groupActivitiesIndex = 0;
            
        if($groupActivitiesIndex >= count($groupActivities))
            return $this->render('thanks');
 
        $course = \common\models\Course::find()->where(['id' => $groupActivities[$groupActivitiesIndex]['course_id']])->one();
        $instructor = \common\models\Instructor::find()->where(['id' => $groupActivities[$groupActivitiesIndex]['instructor_id']])->one();
        $activityType = \common\models\ActivityType::find()->where(['id' => $groupActivities[$groupActivitiesIndex]['activity_type_id']])->one();
        $group = \common\models\Group::find()->where(['id' => $groupActivities[$groupActivitiesIndex]['group_id']])->one();        

		return $this->render('survey', [
		    'course' => $course,		
		    'instructor' => $instructor,
		    'group' => $group,
		    'activityType' => $activityType,
		    'subgroup' => $groupActivities[$groupActivitiesIndex]['subgroup'],
		    'groupActivitiesIndex' => $groupActivitiesIndex,
	    ]);
    }        
    
    public function actionSubmit($iframe = true)
    {
        $groupActivitiesIndex = \Yii::$app->session->get('survey.groupActivitiesIndex');
        if($groupActivitiesIndex === null)
            $groupActivitiesIndex = 0;
        else
            $groupActivitiesIndex++;
        \Yii::$app->session->set('survey.groupActivitiesIndex', $groupActivitiesIndex);

        $group_id = \Yii::$app->session->get('survey.groupId');

        if(!$iframe)
            echo '<script>location.href="'. Url::to(['survey/survey', 'group_id' => $group_id]) .'";</script>';
        else        
            echo '<script>window.top.location.href = "'. Url::to(['survey/survey', 'group_id' => $group_id]) .'";</script>';
    }
}
