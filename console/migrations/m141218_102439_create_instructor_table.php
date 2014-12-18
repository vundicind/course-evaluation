<?php

use yii\db\Schema;
use yii\db\Migration;

class m141218_102439_create_instructor_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%instructor}}', [
            'id' => Schema::TYPE_PK,
            'first_name' => Schema::TYPE_STRING . ' NOT NULL',
            'last_name' => Schema::TYPE_STRING . ' NOT NULL',
            'middle_name' => Schema::TYPE_STRING . ' NOT NULL',            
        ], $tableOptions);
        
        $this->createIndex('NAME', '{{%instructor}}', ['first_name', 'last_name', 'middle_name'], true);
    }

    public function down()
    {
        $this->dropIndex('NAME', '{{%instructor}}');
        
        $this->dropTable('{{%instructor}}');
    }
}
