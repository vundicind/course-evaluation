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
    	'settings' => [
    		'class' => 'pheme\settings\components\Settings',
    	],    		
    ],
	'modules' => [
		'settings' => [
			'class' => 'pheme\settings\Module',
		],			
	],	
];