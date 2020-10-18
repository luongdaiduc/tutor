<?php
$root = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';

$hostname = $_SERVER['SERVER_NAME'];
$datas = require_once($root . DIRECTORY_SEPARATOR . 'multisite' . DIRECTORY_SEPARATOR .  'domains.php');
foreach ($datas as $data)
{
	//local
	$short_domain = $data['domain'];
	$www_domain = 'front.' . $short_domain;
	$admin_domain = 'admin.' . $short_domain;
	//live site
// 		$short_domain = $data['domain'];
// 		$www_domain = 'www.' . $short_domain;
// 		$admin_domain = 'admin.' . $short_domain;
	if($short_domain == $hostname || $www_domain == $hostname || $admin_domain == $hostname)
	{
		$siteUrl = 'http://' . $www_domain;
		$adminUrl = 'http://' . $admin_domain;
	
		$domain_name = $short_domain;
	
		//local
		$db = array(
				'connectionString' => 'mysql:host=localhost;dbname=' . $data['db_name'],
				'emulatePrepare' => true,
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
				'class' => 'CDbConnection',
			);
// 		live site
// 		$db = array(
// 				'connectionString' => 'mysql:host=localhost;dbname=' . $data['db_name'],
// 				'emulatePrepare' => true,
// 				'username' => 'tutor_nlsoft',
// 				'password' => 'nlsoft@2012',
// 				'charset' => 'utf8',
// 				'class' => 'CDbConnection',
// 			);
		$cache_key = $short_domain;
		$domain = '.' . $short_domain;
		$route = array(
			$siteUrl => 'site',
			'http://<domain>.' . $short_domain => 'tutor/detail',
			'http://<domain>.' . $short_domain . '/gallery' => 'tutor/gallery',
			'http://<domain>.' . $short_domain . '/video' => 'tutor/video',
			'http://<domain>.' . $short_domain . '/review' => 'tutor/review',
			'http://<domain>.' . $short_domain . '/contact' => 'tutor/contact',
			
		);
	}
}
// switch ( strtolower($hostname))
// {
// 	//local
// 	case 'front.tutor.com':
// 	case 'admin.tutor.com':
// 		$siteUrl = 'http://front.tutor.com';
// 		$adminUrl = 'http://admin.tutor.com';
// 	//livesite
// // 	case 'www.melbournetutor.org':
// // 	case 'melbournetutor.org':
// // 	case 'admin.melbournetutor.org':
// // 		$siteUrl = 'http://www.melbournetutor.org';
// // 		$adminUrl = 'http://admin.melbournetutor.org';
		
// 		$domain_name = 'melbournetutor.org';
		
// 		$db = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db_melbourne.php');
// 		$cache_key = 'melbourne';
// 		$domain = '.melbournetutor.org';
// 		$route = 'route_melbourne.php';
		
// 		break;
// 	//livesite
// 	case 'www.sydneytutor.org':
// 	case 'sydneytutor.org':
// 	case 'admin.sydneytutor.org':
// 		$siteUrl = 'http://www.sydneytutor.org';
// 		$adminUrl = 'http://admin.sydneytutor.org';
		
// 		$domain_name = 'sydneytutor.org';
		
// 		$db = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db_sydney.php');
// 		$cache_key = 'sydney';
// 		$domain = '.sydneytutor.org';
// 		$route = 'route_sydney.php';
		
// 		break;
// 	//dev site
// 	case 'www.dev-tutor.com':
// 	case 'dev-tutor.com':
// 	case 'admin.dev-tutor.com':
// 		$siteUrl = 'http://www.dev-tutor.com';
// 		$adminUrl = 'http://admin.dev-tutor.com';
		
// 		$domain_name = 'dev-tutor.com';
		
// 		$db = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db_dev.php');
// 		$cache_key = 'dev';
// 		$domain = '.dev-tutor.com';
// 		$route = 'route_dev.php';
		
// 		break;

// 	default:
		//local
// 		$siteUrl = 'http://front.tutor.com';
// 		$adminUrl = 'http://admin.tutor.com';
		//livesite
// 		$siteUrl = 'http://www.melbournetutor.org';
// 		$adminUrl = 'http://admin.melbournetutor.org';
		
// 		$domain_name = 'melbournetutor.org';
		
// 		$db = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db_melbourne.php');
// 		$cache_key = 'melbourne';
// 		$domain = '.melbournetutor.org';
// 		$route = 'route_melbourne.php';
// }
