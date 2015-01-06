<?php
use yii\db\Schema;
use yii\db\Migration;
class m150106_154639_create_semester_table extends Migration {
	public function up() {
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
		
		$this->createTable ( '{{%semester}}', [ 
				'id' => Schema::TYPE_PK,
				'name' => Schema::TYPE_STRING . ' NOT NULL' 
		], $tableOptions );
		
		$this->createIndex ( 'NAME', '{{%semester}}', 'name', true );
	}
	public function down() {
		$this->dropIndex ( 'NAME', '{{%semester}}' );
		
		$this->dropTable ( '{{%semester}}' );
	}
}
