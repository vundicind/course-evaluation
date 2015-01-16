<?php
foreach($groupCourses as $course)
{
    echo '<h3>' . $course['course']['name'] . '</h3>';
    foreach($course['activities'] as $aid => $activity)
    {
        foreach($activity as $iid => $instructor)
        {
            echo $instructor;
            $int = true;
            foreach($course['activities'] as $aid2 => $activity2)
                if(!in_array($instructor, $activity2))
                {
                    $int = false;
                    break;
                }
            if($int) echo ' (integral)<br />';    
        }    
    }
}
