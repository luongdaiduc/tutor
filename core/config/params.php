<?php
return array(

	'siteUrl' => $siteUrl,
	'adminUrl' => $adminUrl,

	//domain name, multi site
	'domain_name' => $domain_name,
	
	//notify expire account day
	'notify_expire_day'=> 10,
		
	//setting cache name
	'cacheSettingsId'=>'settings',
		
	//subject cache name
	'cacheSubjectsId'=>'subjects',

	//subject level cache name
	'cacheLevelId'=>'levels',
		
	//delivery cache name
	'cacheDeliveryId'=>'deliveries',
		
	//state cache name
	'cacheStatesId'=>'states',
	
	//translation category cache name
	'cacheCategoryId'=>'categories',
	
	//translation message cache name
	'cacheTranslateMessageId'=>'translateMessages',
		
	//subject cache name
	'cacheTutorSubjectId'=>'tutor_subject_',
		
	//cache's expired time
	'cache_expire'=>60*60*3,

	//upload gallery path
	'upload_gallery'=>'uploads/galleries/' . $domain_name,	
		
	//upload invoice path
	'upload_invoice'=>'uploads/invoices',
	
	//paypal return text
	'paypal_return_text'=>'Return to sandbox@ossigeno.com.au',
);
