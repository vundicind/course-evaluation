<?php

use yii\db\Schema;
use yii\db\Migration;
use common\models\User;

class m141216_084811_insert_backend_user extends Migration
{
    public function up()
    {
        $user = new User;
        $user->username = 'admin';
        $user->setPassword('Samsung_1');
        $user->email = 'elearning@usarb.md';
        $user->save();
    }

    public function down()
    {
        echo "m141216_084811_insert_backend_user cannot be reverted.\n";

        return false;
    }
}
