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
    public $src = '';
    public $surveyId = '';
    public $params = [];    
    
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
        $_lang = (!empty($this->lang))?'lang=' . $this->lang : '';
        $_params = '';
        foreach($this->params as $param=>$value)
            $_params .= $param . '=' . $value . '&';

        echo Html::beginTag('iframe', ['src' => $this->src . '/index.php/' . $this->surveyId . '/lang/' . $_lang . '/newtest/Y?' . $_params, 'width' => '100%', 'height' => '800px', 'name' => 'Survey EN', 'frameborder' => '0']);
        echo '<p>Your browser doesn\'t support frames. You can call the page here: <a href="http://91.250.115.126/index.php/survey/index/sid/288891/lang/en">Survey My Europe</a></p>';
        echo Html::endTag('iframe');
    }

}
