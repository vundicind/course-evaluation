<?php

use yii\db\Schema;
use yii\db\Migration;

class m141218_100550_create_course_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%course}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);
        
        $this->createIndex('NAME', '{{%course}}', 'name', true);
    }

    public function down()
    {
        $this->dropIndex('NAME', '{{%course}}');
        
        $this->dropTable('{{%course}}');
    }
}
