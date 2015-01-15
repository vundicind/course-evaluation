<?php

use yii\db\Schema;
use yii\db\Migration;

class m150115_115952_modify_group_activity_table extends Migration
{
    public function up()
    {
    	$this->createIndex('ALL', '{{%group_activity}}', ['group_id', 'activity_type_id', 'course_id', 'instructor_id', 'semester_id'], true);
    }

    public function down()
    {
        $this->dropIndex('ALL', '{{%group_activity}}');
    }
}
