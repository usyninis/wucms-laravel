<?php

HTML::macro('jquery', function($version='1.11.1')
{
	return '<script src="//ajax.googleapis.com/ajax/libs/jquery/'.$version.'/jquery.min.js"></script>
<script type="text/javascript">
window.jQuery || document.write(\'<script type="text/javascript" src="'.url('packages/jquery/jquery-'.$version.'.min.js').'"><\/script>\');
</script>';
});



HTML::macro('content', function($html)
{

	//$snppts = ['url'];

	
	//$reg_exUrl = "!recipes:{(.*?)}!si";
	if (preg_match_all('!{(.*?)}!si', $html, $a)) 
	{
		// Проверяем наличие адреса url в строке
		
		//if(array_get(1,$a))
		foreach($a[1] as $snppt)
		{
			//return print_r($snppt,1);
			$t = explode(':',$snppt,2);
			$snppt_code = $t[0];
			if($snppt_vars_tmp = $t[1])
			{
				$snppt_vars = [];
				$snppt_vars = explode(';',$snppt_vars_tmp);
				/* $snppt_vars = [];
				$snppt_vars_tmp = explode(';',$vars_text);
				foreach($snppt_vars_tmp as $key_value)
				{
					list($key,$value) = explode(':',$key_value,2);
					$snppt_vars[$key] = $value;
				} */
				
			}
			else
			{
				$snppt_vars = []; 
			}
			$snppt_res = '';
			switch($snppt_code)
			{
				case 'unit_url':
					$snppt_res = Unit::url($snppt_vars[0]);
					break;
				case 'unit_link':
					if($unit = Unit::find($snppt_vars[0]))
						$snppt_res = HTML::link($unit->url,$unit->name);
					break;
			}
			$html = str_replace('{'.$snppt.'}',$snppt_res,$html);
		}
	} 
	//}
	return $html;
	
});