<?php

use yii\db\Schema;
use yii\db\Migration;

class m150820_184441_insert_default_settings extends Migration
{
    public function up()
    {
        $settings = Yii::$app->settings;
        
        $settings->set('survey.username', 'admin', 'LimeSurvey', 'string');
        $settings->set('survey.password', 'Samsung_1', 'LimeSurvey', 'string');
        $settings->set('survey.url', 'http://dmc.usarb.md/limesurvey', 'LimeSurvey', 'string');
        $settings->set('survey.surveyId', '453434', 'LimeSurvey', 'integer');                        

        $settings->set('app.semesterId', '1', 'LimeSurvey', 'integer');                        
    }

    public function down()
    {
        echo "m150820_184441_insert_default_settings cannot be reverted.\n";

        return false;
    }
}
