<?php

use yii\db\Schema;
use yii\db\Migration;

class m150108_131628_modify_group_table extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%group}}', 'study_form_id', Schema::TYPE_INTEGER . ' AFTER `specialty_id`');
        
        $this->addForeignKey('FK_group_study_form', '{{%group}}', 'study_form_id', '{{%study_form}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('FK_group_study_form', '{{%group}}');
        
        $this->dropColumn('{{%goup}}', 'study_form_id');        
    }

}
