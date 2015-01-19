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
        \Yii::$app->session->set('survey.groupActivities', null);
    
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
        
        $groupActivities = \Yii::$app->session->get('survey.groupActivities');
        $groupActivitiesIndex = \Yii::$app->session->get('survey.groupActivitiesIndex');

        if($groupActivities == null)
    	{
    	    $groupActivitiesIndex = null;
    	    
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
                        if(array_key_exists($p, $instructor['activities']))
                        {
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
            die('<span style="font-size:18px;">Vă mulţumim pentru sprijinul acordat!</span>');    
 
        $course = \common\models\Course::find()->where(['id' => $groupActivities[$groupActivitiesIndex]['course_id']])->one();
        $instructor = \common\models\Instructor::find()->where(['id' => $groupActivities[$groupActivitiesIndex]['instructor_id']])->one();
        $activityType = \common\models\ActivityType::find()->where(['id' => $groupActivities[$groupActivitiesIndex]['activity_type_id']])->one();

		return $this->render('survey', [
		    'courseId' => $course->id,		
		    'courseName' => $course->name,
		    'instructorId' => $instructor->id,
		    'instructorFullName' => $instructor->full_name,
		    'activityTypeId' => $groupActivities[$groupActivitiesIndex]['activity_type_id'],
		    'activityTypeName' => ($activityType !== null)?$activityType->name:'',
		    'subgroup' => $groupActivities[$groupActivitiesIndex]['subgroup'],
		    'groupActivitiesIndex' => $groupActivitiesIndex,
			'cc' => $this->getCode('SPECIALITATEA', 'Management educațional'),
	    ]);
    }        
    
    public function actionSubmit()
    {
        $groupActivitiesIndex = \Yii::$app->session->get('survey.groupActivitiesIndex');
        if($groupActivitiesIndex === null)
            $groupActivitiesIndex = 0;
        else
            $groupActivitiesIndex++;
        \Yii::$app->session->set('survey.groupActivitiesIndex', $groupActivitiesIndex);

        echo '<script>window.top.location.reload();</script>';
    }
    
    public function getCode($type, $name)
    {
    	$result = '';    	
    	$surveyId = \Yii::$app->survey->surveyId;
    	foreach(\Yii::$app->survey->listGroups($surveyId) as $gData) {
    		if($gData['id']['language'] == 'ro' && $gData['group_name'] == 'META') {
    			foreach(\Yii::$app->survey->listQuestions($surveyId, $gData['id']['gid']) as $qData)
    			{
    				if($qData['title'] == 'SPECIALITATEA' && $type == 'SPECIALITATEA')
    				{
    					$props = \Yii::$app->survey->getQuestionProperties($qData['id']['qid'], ['answeroptions','question','attributes']);

    					foreach($props['answeroptions'] as $code=>$opt)
    					{
    						if(strtolower($name) == strtolower($opt['answer']))
    						{
    							$result = $code;
    							break;
    						}
    					}
    				}
    				if($qData['title'] == 'GRUPA' && $type == 'GRUPA')
    				{
    				}
    				if($qData['title'] == 'DISCIPLINA' && $type == 'DISCIPLINA')
    				{
    				}
    				if($qData['title'] == 'PROFESORUL' && $type == 'PROFESORUL')
    				{
    				}
    			}
    		}
    	}

    	return $result;
    }
}
