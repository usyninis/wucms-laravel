<?php

return array(

	'app_enable'	=> true,

	'app_code'		=> 'demo',

	'admin_url'		=> 'admin',
	
	'access_panel'	=> array('superadmin','admin','manager'),	
	
	'access_debug'	=> array(1), // users to debug btn
	
	'auth'			=> array(
	
		'driver'	=> 'eloquent',
		'model'		=> 'Usyninis\Wucms\User',
		'table'		=> 'users'
	
	),
	
	'gallery'		=> array(
	
		'driver'				=> 'imagick',
	
		'upload_path'			=> 'upload',
		'upload_images_path'	=> 'upload/images',
		'upload_documents_path'	=> 'upload/documents',
		
		'thumb_enable'			=> true,	
		'thumb_path'			=> 'upload/thumb',		
		'watermark_src'			=> 'img/watermark.png'
		
	)
	
	
);
