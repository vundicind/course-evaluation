<?php

use yii\db\Schema;
use yii\db\Migration;

class m141217_083040_create_group_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%group}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'specialty_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        
        $this->addForeignKey('FK_group_specialty', '{{%group}}', 'specialty_id', '{{%specialty}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->createIndex('NAME', '{{%group}}', ['name', 'specialty_id'], true);
    }

    public function down()
    {
        $this->dropIndex('NAME', '{{%group}}');
        $this->dropForeignKey('FK_group_specialty', '{{%group}}');
        
        $this->dropTable('{{%group}}');
    }
}
