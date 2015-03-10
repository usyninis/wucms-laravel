<?php

	$cuser = User::findOrNew(Input::get('id'));

?>
<meta name="wu-modal-title" content="Редактирование пользователя">
<meta name="wu-modal-width" content="400">

	
@if($cuser->id)
	
{{ Form::model($cuser,[
	'route'		=> array('admin.users.update',$cuser->id),	
	'autocomplete'	=> 'off',
	'class'			=> 'js-form forms end forms-s1',
	'data-pubs'	=> 'notifyModal',
	'method'	=> 'PUT'
	
]) }}

@else

{{ Form::model($cuser,[
	'route'		=> array('admin.users.store'),	
	'class'		=> 'js-form forms end forms-s1',
	'data-pubs'	=> 'notifyModal',
	'method'	=> 'POST'
	
]) }}

@endif
	
	<label>{{ trans('wucms::user.fields.first_name') }}{{ Form::text('first_name',null,['class' => 'width-100']) }}</label>
	<label>{{ trans('wucms::user.fields.last_name') }}{{ Form::text('last_name',null,['class' => 'width-100']) }}</label>
	<label>{{ trans('wucms::user.fields.email') }}{{ Form::text('email',null,['class' => 'width-100']) }}</label>
	<label>{{ trans('wucms::user.fields.new_password') }}{{ Form::password('new_password',['class' => 'width-100']) }}</label>
	<div class="groups-title"><span>Группы пользователя</span></div>
	<div class="checkboxs-list">
		
		@foreach(Role::all() as $role)
			<label>{{ Form::checkbox('roles[]',$role->id,in_array($role->id,$cuser->roles()->lists('id'))) }} {{ $role->role }} </label>
		@endforeach
	</div>
	{{ Form::button('Сохранить',array('class' => 'btn btn-orange','type'=>'submit')) }}
	{{ Form::button('Отмена',array('class'	=> 'js-wu-modal-close btn','type'=>'button')) }}
{{ Form::close() }}