<?php
	$setting = Setting::findOrNew(Input::get('id'));
?>

	{{ Form::model($setting,[
		'data-action'	=> 'settings/save',
		'data-pubs'		=> 'notifyModal reload',
		'class'			=> 'forms end js-form'
	]) }}
		{{ Form::hidden('id') }}
		
		<label>Код{{ Form::text('code',null,['class'=>'width-100']) }}</label>
	
		<label>Название{{ Form::text('name',null,['class'=>'width-100']) }}</label>
		
		<label>Тип значения свойства{{ Form::wuSelector('type',Setting::typesList(),$setting->type,['class'=>'width-100']) }}</label>
		
		<div class="group">
		{{ Form::button('Сохранить',['type'=>'submit','class'=>'btn btn-orange']) }}
		{{ Form::button('Отмена',['class'=>'btn js-wu-modal-close']) }}
		@if($setting->id)
		<button class="btn right btn-red js-confirm-ajax" data-action="settings/delete" data-pub="notify" data-id="{{ $setting->id }}" title="Удалить настройку" type="button"><i class="fa fa-trash-o"></i></button>
		@endif
		</div>
	{{ Form::close() }}

