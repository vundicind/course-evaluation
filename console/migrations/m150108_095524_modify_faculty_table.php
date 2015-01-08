<?php

use yii\db\Schema;
use yii\db\Migration;

class m150108_095524_modify_faculty_table extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%faculty}}', 'short_name', Schema::TYPE_STRING . ' AFTER `name`');

        $this->createIndex('SHORT_NAME', '{{%faculty}}', 'short_name', true);
    }

    public function down()
    {
        $this->dropIndex('SHORT_NAME', '{{%faculty}}');

        $this->dropColumn('{{%faculty}}', 'short_name');        
    }
}
