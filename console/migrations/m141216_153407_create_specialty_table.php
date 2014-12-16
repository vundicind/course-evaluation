<?php

use yii\db\Schema;
use yii\db\Migration;

class m141216_153407_create_specialty_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%specialty}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'faculty_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'study_cycle_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        
        $this->addForeignKey('FK_specialty_faculty', '{{%specialty}}', 'faculty_id', '{{%faculty}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('FK_specialty_study_cycle', '{{%specialty}}', 'study_cycle_id', '{{%study_cycle}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('FK_specialty_faculty', '{{%specialty}}');
        $this->dropForeignKey('FK_specialty_study_cycle', '{{%specialty}}');
        
        $this->dropTable('{{%specialty}}');
    }
}
