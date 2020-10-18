<?php 
$root = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';

Yii::setPathOfAlias('core', $root . DIRECTORY_SEPARATOR . 'core');
Yii::setPathOfAlias('extensions', $root . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'extensions');

include $root . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR .  'pre_config.php';

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Melbourne Tutors',

	// preloading 'log' component
	'preload'=>array('log'),
		
	'sourceLanguage'=>'en',
// 	'language' => 'vi',
		
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'core.models.base.*',
		'core.models.form.*',
		'core.models.*',
		'core.components.*',
		'core.extensions.*',
			'core.extensions.imagecropper.*',
		'application.modules.hybridauth.controllers.*',
	),

	'modules'=>array(
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
// 			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
		//hybridauth module
		'hybridauth' => array(
            'baseUrl' => 'http://'. $_SERVER['SERVER_NAME'] . '/hybridauth', 
            'withYiiUser' => false, // Set to true if using yii-user

        ),
	),

	// application components
	'components'=>array(
		'messages' => array(
			'class' => 'CDbMessageSource',
			'sourceMessageTable' => 'i18n_source_messages',
			'translatedMessageTable' => 'i18n_messages',	
			'cachingDuration' => '504000',
			'cacheID' => 'translate_message',
		),				
		'cache'=>array(
			'class'=>'CFileCache',
			'cachePath'=> '/home/melbournetutor/dev/cache',
			'keyPrefix'=> $cache_key
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
// 			'identityCookie'=> array('domain'=>$domain)
		),
		'session' => array(
// 			'savePath' => '/',
			'cookieMode' => 'allow',
// 			'cookieParams' => array(
// 				'path' => '/',
// 				'domain' => $domain,
// 				'httpOnly' => true,
// 			),
		),
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>CMap::mergeArray(require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'routes.php'), $route),
		),
		
// 		'db'=>array(
// 			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
// 		),
		
		'db'=>$db,
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
			
		'mailer' => array(
				'class' => 'XSwiftMailer',
		),

		'ePdf' => array(
				'class'         => 'EYiiPdf',
				'params'        => array(
						'mpdf'     => array(
								'librarySourcePath' => 'extensions.MPDF.*',
								'constants'         => array(
										'_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
								),
								'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder.
								/*'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
								 'mode'              => '', //  This parameter specifies the mode of the new document.
										'format'            => 'A4', // format A4, A5, ...
										'default_font_size' => 0, // Sets the default document font size in points (pt)
										'default_font'      => '', // Sets the default font-family for the new document.
										'mgl'               => 15, // margin_left. Sets the page margins for the new document.
										'mgr'               => 15, // margin_right
										'mgt'               => 16, // margin_top
										'mgb'               => 16, // margin_bottom
										'mgh'               => 9, // margin_header
										'mgf'               => 9, // margin_footer
										'orientation'       => 'P', // landscape or portrait orientation
								)*/
						),
						'HTML2PDF' => array(
								'librarySourcePath' => 'extensions.html2pdf.*',
								'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
								/*'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
								 'orientation' => 'P', // landscape or portrait orientation
										'format'      => 'A4', // format A4, A5, ...
										'language'    => 'en', // language: fr, en, it ...
										'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
										'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
										'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
								)*/
						)
				),
		),
			
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require_once(dirname(__FILE__) . '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR. 'core' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'params.php' ),
);
