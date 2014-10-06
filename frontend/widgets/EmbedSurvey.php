<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Allows you to place your survey directly into page on your website.
 * 
 * @author Radu Dumbrăveanu <vundicind@gmail.com>
 */
class EmbedSurvey extends Widget {
    
    public $lang = '';
    
    /**
     * qcode => answer
     * @var type 
     */
    public $preFilledAnswers = [];
    
    public function init() {
        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run() {
        echo Html::beginTag('iframe', ['src' => 'http://elearning.usarb.md/dmc/cc/index.php/survey/index/sid/671178/newtest/Y/lang/ro?FACULTATE=A2', 'width' => '100%', 'height' => '400px', 'name' => 'Survey EN', 'frameborder' => '0']);
        echo '<p>Your browser doesn\'t support frames. You can call the page here: <a href="http://91.250.115.126/index.php/survey/index/sid/288891/lang/en">Survey My Europe</a></p>';
        echo Html::endTag('iframe');
    }

}
