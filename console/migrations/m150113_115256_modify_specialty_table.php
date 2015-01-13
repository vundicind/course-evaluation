<?php

use yii\db\Schema;
use yii\db\Migration;

class m150113_115256_modify_specialty_table extends Migration
{
    public function up()
    {
    	$this->createIndex('NAME', '{{%specialty}}', ['name', 'faculty_id', 'study_cycle_id'], true);
    }

    public function down()
    {
        $this->dropIndex('NAME', '{{%specialty}}');
    }
}
