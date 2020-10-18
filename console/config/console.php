<?php
$root = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';

Yii::setPathOfAlias('core', $root . DIRECTORY_SEPARATOR . 'core');

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.

$config = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
		
	// autoloading model and component classes
	'import'=>array(
			'application.models.*',
			'application.components.*',
			'core.models.base.*',
			'core.models.form.*',
			'core.models.*',
			'core.components.*',
	),
	// application components
	'components'=>array(
		'cache'=>array(
				'class'=>'CFileCache',
				'cachePath'=>  '/home/melbournetutor/public_html/cache',
				'keyPrefix' => 'melbourne'
		),
			
		'user'=>array(
				// enable cookie-based authentication
				'allowAutoLogin'=>true,
		),
			
	),
		
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
// 	'params'=>require_once(dirname(__FILE__) . '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. 'core' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'params.php' ),		
);

//database config
$db_config = require_once($root . DIRECTORY_SEPARATOR . 'multisite' . DIRECTORY_SEPARATOR . 'db_console_config.php');

$config['components'] = CMap::mergeArray($config['components'], $db_config);

return $config;