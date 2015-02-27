<?php

return array(

	'app_code'		=> 'demo',
	'site_enable'	=> true,
	
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
