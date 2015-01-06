<?php

use yii\db\Schema;
use yii\db\Migration;

class m150106_160327_modify_group_activity_table extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%group_activity}}', 'semester_id', Schema::TYPE_INTEGER . ' AFTER `instructor_id`');

    	$this->addForeignKey('FK_group_activity_semester', '{{%group_activity}}', 'semester_id', '{{%semester}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('FK_group_activity_semester', '{{%group_activity}}');
        
        $this->dropColumn('{{%group_activity}}', 'semester_id');        
    }
}
