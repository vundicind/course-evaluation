<?php

use yii\db\Schema;
use yii\db\Migration;

class m141222_063039_create_group_activity_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%group_activity}}', [
            'id' => Schema::TYPE_PK,
            'group_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'activity_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'course_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'instructor_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'subgroup' => Schema::TYPE_BOOLEAN . ' NOT NULL',
        ], $tableOptions);
        
        $this->addForeignKey('FK_group_activity_group', '{{%group_activity}}', 'group_id', '{{%group}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('FK_group_activity_activity_type', '{{%group_activity}}', 'activity_type_id', '{{%activity_type}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('FK_group_activity_course', '{{%group_activity}}', 'course_id', '{{%course}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('FK_group_activity_instructor', '{{%group_activity}}', 'instructor_id', '{{%instructor}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('FK_group_activity_group', '{{%group_activity}}');
        $this->dropForeignKey('FK_group_activity_activity_type', '{{%group_activity}}');
        $this->dropForeignKey('FK_group_activity_course', '{{%group_activity}}');
        $this->dropForeignKey('FK_group_activity_instructor', '{{%group_activity}}');
        
        $this->dropTable('{{%group_activity}}');
    }
}
