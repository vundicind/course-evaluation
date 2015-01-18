<?php

foreach($groupCourses as $course)
{
    echo '<h3>' . $course['course']['name'] . '</h3>';

    foreach($course['instructors'] as $iid => $instructor)
    {
        if(count($instructor['activities']) >= 2)
        {
            echo 'Question: Ați avut ' . $course['course']['name'] . ' - ' . 'curs integral' . '?';
            echo '<br />';
            echo $instructor['instructor']['fullName'];
            continue;
        }    
            
        foreach($instructor['activities'] as $aid => $activity)
        {
            if($activity['activity']['subgroup'])
            {
                echo 'Question: Ați avut ' . $course['course']['name'] . ' - ' . $activity['activity']['name'] . '?';
            }
            
            echo '<br />';
            echo $activity['activity']['name'] . ': ' . $instructor['instructor']['fullName'];
        }    
    }
}
