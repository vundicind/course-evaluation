<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
        	'showScriptName' => false,
    	],
		'survey' => [
    		'class' => 'common.components.LimeSurvey',
    		'username' => 'admin',
    		'password' => 'Samsung_1',
    		'url' => 'http://elearning.usarb.md/dmc/limesurvey',
			'surveyId' => '429785',		
		]    		
    ],
];