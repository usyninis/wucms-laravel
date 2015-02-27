<?php

/*
|--------------------------------------------------------------------------
| Delete form macro
|--------------------------------------------------------------------------
|
| This macro creates a form with only a submit button. 
| We'll use it to generate forms that will post to a certain url with the DELETE method,
| following REST principles.
|
*/
Form::macro('delete',function($url, $button_label='Delete',$form_parameters = array(),$button_options=array())
{

    if(empty($form_parameters)){
        $form_parameters = array(
            'method'=> 'DELETE',
            //'class' => 'js-delete-form',
            'url'   => $url
        );
    }else{
        $form_parameters['url'] = $url;
        $form_parameters['class'] = 'js-delete-form end '.array_get($form_parameters,'class');
        $form_parameters['method'] = 'DELETE';
    };
	
	$button_options['type'] = 'submit';
	
    return Form::open($form_parameters)
            . Form::button($button_label, $button_options)
            . Form::close();
});



Form::macro('parent_unit', function($parent_id,$unit_id)
{
	$html = '';
	$html .= '<div id="parent-'.$unit_id.'" class="wu-selector js-wu-modal" data-active-id="'.$parent_id.'" data-hide-id="'.$unit_id.'" data-code="units" data-pub="selector:paste" data-selector="#parent-'.$unit_id.'">';
	$html .= Form::hidden('parent_id',$parent_id);
	$html .= '<i class="wu-sel-icon fa fa-ellipsis-h"></i>';
	if($parent_unit = Unit::find($parent_id))
		$html .= '<div class="sel-item">'.$parent_unit->name.'</div>';
	else
		$html .= '<div class="sel-item"></div>';
	
	$html .= '</div>';
	return $html;
});

/*
|--------------------------------------------------------------------------
| wuCheckbox macro
|--------------------------------------------------------------------------
|
| This macro creates a form with only a submit button. 
| We'll use it to generate forms that will post to a certain url with the DELETE method,
| following REST principles.
|
*/

Form::macro('wuCheckbox', function($name=null, $value=null, $checked=false, $attr=array())
{
	$html = '<div class="wu-checkbox-field '.array_get($attr,'class').'">';
	$html .= '<label class="wu-checkbox'.($checked?' checked':'').'">';	
	$html .= Form::checkbox($name,$value,$checked);
	$html .= '<div class="wu-checkbox-ind"></div>';	
	$html .= '<div class="wu-checkbox-sts wu-checkbox-sts-on">Да</div>';	
	$html .= '<div class="wu-checkbox-sts wu-checkbox-sts-off">Нет</div>';	
	
	$html .= '</label>';
	$html .= '<div class="wu-checkbox-label">'.array_get($attr,'label').'</div>';
	$html .= '</div>';
	return $html;
});

Form::macro('wuSelector', function($name=null,$items=[],$value=null,$attr=[])
{
	//print_array($items);
	$aitem = array_get($items,$value);
	$sel_icon =  array_get($attr,'sel-icon','fa-chevron-down');
	//$sel_icon =  array_get($attr,'sel-icon','fa-chevron-down');
	$html = '<div class="wu-selector '.array_get($attr,'class').'">';
	$html .= Form::hidden($name,$value);
	$html .= '<i class="wu-sel-icon fa '.$sel_icon.'"></i>';
	$html .= '<div class="sel-item">'.(is_array($aitem)?array_get($aitem,'name'):$aitem).'</div>';
	if(!empty($items))
	{
		$html .= '<div class="sel-section">';
		foreach($items as $ikey => $item)	
		{
			
			$html .= '<div data-value="'.$ikey.'" class="item'.($ikey==$value?' active':'').'">';
			$html .= '<div class="item-name">'.(is_array($item)?array_get($item,'name'):$item).'</div>';
			$html .= '<div class="item-description">'.array_get($item,'description').'</div>';
			$html .= '<i class="wu-sel-item-icon fa fa-check"></i>';
			$html .= '</div>';
		}		
			/* $html .= '<div class="item">';
			$html .= '<div class="item-name">ITEM 2</div>';
			$html .= '<div class="item-desk">item 2 description</div>';
			$html .= '</div>';
				
			$html .= '<div class="item active">';
			$html .= '<div class="item-name">ITEM 3</div>';
			$html .= '<div class="item-desk">item 3 description</div>';
			$html .= '</div>'; */
				
				
		$html .= '</div>';	
	}
	$html .= '</div>';
	return $html;
});

Form::macro('prop', function($prop, $unit_props=array())
{
	$html = '<div class="prop-field group">';
	$html .= '<div class="prop-name">';
	$html .= $prop->name;
	if($prop->multiple) $html .= '<i class="fa fa-plus js-pub right" title="Добавить значение свойства" data-pub="cloneProp" data-id="'.$prop->id.'"></i>';
	if($prop->description) $html .= '<i class="fa fa-question-circle right" title="'.$prop->description.'"></i>';
	$html .= '</div>';
	$html .= '<div class="prop-values'.($prop->multiple? ' js-sortable-props' : '').'">';
	$bvhtml = '<div class="prop-value">'; // html до input свайства
	if($prop->multiple) $bvhtml .= '<div class="width-10 right prop-cntrl"><i class="fa fa-sort js-handle"></i><i class="js-remove-prop-val fa fa-close"></i></div>';
	$avhtml = '';
	 // html до input свайства
	$avhtml .= '</div>';
	$need_empty = true;
	switch($prop->type)
    {
		case 'int':
			
			foreach($unit_props as $uprop) //dd($uprop);
			//print_array($uprop->prop);
			if($uprop->prop_id==$prop->id) 
			{		
				$need_empty = false;		
				$html .= $bvhtml.Form::text('props['.$prop->id.'][]',$uprop->value_int,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
			}
			if($prop->multiple || $need_empty) $html .= $prop_tpl = $bvhtml.Form::text('props['.$prop->id.'][]',null,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
			break;
			
		case 'string':
			foreach($unit_props as $uprop) //dd($uprop);
			if($uprop->prop_id==$prop->id) 
			{
				$need_empty = false;		
				
				$html .= $bvhtml.Form::text('props['.$prop->id.'][]',$uprop->value_string,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
			}
			if($prop->multiple || $need_empty) $html .= $prop_tpl = $bvhtml.Form::text('props['.$prop->id.'][]',null,['class'=>'width-90']).$avhtml;
			break;
			
		case 'prop':
			$props = ['0'=>'<span class="sel-item-empty">Не выбрано</span>'] +  Prop::all()->lists('name','id');
			foreach($unit_props as $uprop) //dd($uprop);
			if($uprop->prop_id==$prop->id) 
			{
				$need_empty = false;		
				
				$html .= $bvhtml.Form::wuSelector('props['.$prop->id.'][]',$props,$uprop->value_int,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
			}
			if($prop->multiple || $need_empty) $html .= $prop_tpl = $bvhtml.Form::wuSelector('props['.$prop->id.'][]',$props,0,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
			break;
		case 'text':
			foreach($unit_props as $uprop) //dd($uprop);
			if($uprop->prop_id==$prop->id) 
			{
				$need_empty = false;		
				
				$html .= $bvhtml.Form::textarea('props['.$prop->id.'][]',$uprop->value_text,['class'=>'width-90','rows'=>'5']).$avhtml;// $value = $uprop->value_text;
			}
			if($prop->multiple || $need_empty) $html .= $prop_tpl = $bvhtml.Form::textarea('props['.$prop->id.'][]',null,['class'=>'width-90','rows'=>'5']).$avhtml;// $value = $uprop->value_text;
			break;
		case 'album':
			$albums = ['0'=>'<span class="sel-item-empty">Не выбрано</span>'] + Album::lists('name','id');
			foreach($unit_props as $uprop) //dd($uprop);
			if($uprop->prop_id==$prop->id) 
			{
				$need_empty = false;		
				
				$html .= $bvhtml.Form::wuSelector('props['.$prop->id.'][]',$albums,$uprop->value_int,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
			}
			if($prop->multiple || $need_empty) $html .= $prop_tpl = $bvhtml.Form::wuSelector('props['.$prop->id.'][]',$albums,0,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
			break;
		case 'list':
			
			$units = ['0'=>'<span class="sel-item-empty">Не выбрано</span>'] +  Unit::whereParentId($prop->value)->lists('name','id');
			foreach($unit_props as $uprop) //dd($uprop);
			if($uprop->prop_id==$prop->id) 
			{
				$need_empty = false;		
				
				$html .= $bvhtml.Form::wuSelector('props['.$prop->id.'][]',$units,$uprop->value_int,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
			}
			if($prop->multiple || $need_empty) $html .= $prop_tpl = $bvhtml.Form::wuSelector('props['.$prop->id.'][]',$units,0,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
			break;
		case 'checkbox':
			
			
			foreach($unit_props as $uprop) //dd($uprop);
			if($uprop->prop_id==$prop->id) 
			{
				$need_empty = false;		
				
				$html .= $bvhtml.Form::wuCheckbox('props['.$prop->id.'][]',1,$uprop->value_int,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
			}
			if($prop->multiple || $need_empty) $html .= $prop_tpl = $bvhtml.Form::wuCheckbox('props['.$prop->id.'][]',1,0,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
			break;
		case 'unit':
			//$units = ['0'=>'<span class="sel-item-empty">Не выбрано</span>'] + Unit::lists('name','id');
			
			
			foreach($unit_props as $uprop) //dd($uprop);
			if($uprop->prop_id==$prop->id) 
			{
				$need_empty = false;
				$html .= $bvhtml;
				$html .= '<div class="wu-selector width-90 js-wu-modal" data-id="'.$uprop->value_int.'" data-code="units" data-pub="selector:paste" data-selector="#prop-'.$prop->id.' .wu-selector.checked">';
				$html .= Form::hidden('props['.$prop->id.'][]',$uprop->value_int);
				$html .= '<i class="wu-sel-icon fa fa-ellipsis-h"></i>';
				if($vunit = Unit::find($uprop->value_int))
					$html .= '<div class="sel-item">'.$vunit->name.'</div>';
				else
					$html .= '<div class="sel-item"></div>';
				
				$html .= '</div>';
				$html .= $avhtml;
				
				//$html .= $bvhtml.Form::select('props['.$prop->id.'][]',$units,$uprop->value_int,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
			}
			if($prop->multiple || $need_empty) 
			{
				//$html .= $prop_tpl = $bvhtml.Form::select('props['.$prop->id.'][]',$units,0,['class'=>'width-90']).$avhtml;// $value = $uprop->value_text;
				$prop_tpl = $bvhtml;
				$prop_tpl .= '<div class="wu-selector width-90 js-wu-modal" data-id="0" data-code="units" data-pub="selector:paste" data-selector="#prop-'.$prop->id.' .wu-selector.checked">';
				$prop_tpl .= Form::hidden('props['.$prop->id.'][]',0);
				$prop_tpl .= '<i class="wu-sel-icon fa fa-ellipsis-h"></i>';
				$prop_tpl .= '<div class="sel-item"></div>';				
				$prop_tpl .= '</div>';
				$prop_tpl .= $avhtml;
				
				$html .= $prop_tpl;
			}
			break;
		default:
			return '';
	}
    
	
	$html .= '</div>';
	if($prop->multiple) $html .= '<div class="prop-value-template">'.$prop_tpl.'</div>';
	$html .= '</div>';
    return $html;
});

