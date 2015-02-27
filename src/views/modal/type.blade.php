<?php
/*
	$type = Type::find(Input::get('type_id'));
	$type_props = $type->props->lists('id');
	print_r($type_props);

@if($props = Prop::all())

	<div class="group">
	@foreach($props as $prop)
		
		@if(!in_array($prop->id,$type_props))
			<a class="unit" onclick="$('#list-unit-props').">{{ $prop->name }}</a>
			<div id="prop-input-{{ $prop->id }}" class="hide">
				{{ Form::prop($prop,[]) }}
			</div>
		@endif
	@endforeach
	</div>
	
@endif
*/
//$roles->contains(2)

	$type = Type::findOrNew(Input::get('id'));
	$type_props = $type->props;
?>

	<meta name="wu-modal-title" content="Редактирование типа">
	<meta name="wu-modal-width" content="350">
	
{{ Form::model($type,[
	'data-action'	=> 'types/save',
	'data-pubs'	=> 'reload notifyModal',
	'class'	=> 'js-form end forms forms-s1',
]) }}
	{{ Form::hidden('id') }}
	
	 
	
	
	<label>Код{{ Form::text('code',null,['class'=>'width-100']) }}</label>
	<label>Название{{ Form::text('name',null,['class'=>'width-100']) }}</label>
	<label> Шаблон по умолчанию
	{{ Form::wuSelector('template_id',Template::all()->keyBy('id')->toArray(),$type->template_id) }}
	</label>
	
	<div class="groups-title"><span>Свойства объектов этого типа</span></div>
	<div class="checkboxs-list">
	@if($props = Prop::all())
		@foreach($props as $prop)
			<label>{{ Form::checkbox('props['.$prop->id.']',$prop->id,$type_props->contains($prop->id)) }} {{ $prop->name}}</label>
			
			
		@endforeach
	@endif
	</div>
	<div class="hr"></div>
	{{ Form::button('Сохранить',['type'=>'submit','class'=>'btn btn-orange']) }}
	{{ Form::button('Отмена',['class'=>'btn js-wu-modal-close']) }}
	
	@if($type->id)
	<button class="btn btn-red js-confirm-ajax right" data-action="types/delete" data-pub="notify" data-id="{{ $type->id }}" title="Удалить тип" type="button"><i class="fa fa-trash-o"></i></button>
	@endif
{{ Form::close() }}