@extends('wucms::template')



@section('content')


<div class="units-row end h-h100">
	
	<div class="unit-50 list-el-s1">	
		
		<div class="header-s1 group">			
			<h3 class="h-title left">Пользователи</h3>
			<button type="button" id="user-add-btn" class="btn right btn-add js-show" data-show="#user-add-form" data-hide="#user-add-btn">Добавить пользователя</button>
		</div>		
		
			{{ Form::open([
				'action'		=> 'UsersController@store',
				'id'			=> 'user-add-form',
				'class'			=> 'js-form forms hide',
				'data-pubs'		=> 'notify',
			]) }}
				<label>email{{ Form::text('email',null,array('class' => 'width-100')) }}</label>
				{{ Form::button('Сохранить',array('class' => 'btn btn-orange','type'=>'submit')) }}
				{{ Form::button('Отмена',array('class' => 'btn js-show','data-show'=>'#user-add-btn','data-hide'=>'#user-add-form')) }}
			{{ Form::close() }}
		
		<div class="unit-d-units-list">		
		@foreach($users as $user)
			<a class="unit{{ empty($cuser)? '' : ($cuser->id==$user->id ? ' active': '') }}" href="{{ url('admin/users/'.$user->id) }}">
				<span class="u-name">{{ $user->id }} : {{ $user->name }}</span>
				<span class="u-url">{{ $user->email }}</span>
			</a>
		@endforeach		
		</div>
		
	</div>
	
	@if(!empty($cuser))
	<div class="unit-50" style="background:#fff;padding:15px;">
	
	
	{{ Form::model($cuser, array(
		'route'			=> array('admin.users.update',$cuser->id),
		'data-pubs'		=> 'notify',
		'class'			=> 'js-form forms end forms-s1',
		
		'autocomplete'	=> 'off',
		'method'		=> 'PUT'
	)) }}	
		
		<label>{{ trans('user.fields.first_name') }}{{ Form::text('first_name',null,['class' => 'width-100']) }}</label>
		<label>{{ trans('user.fields.last_name') }}{{ Form::text('last_name',null,['class' => 'width-100']) }}</label>
		<label>{{ trans('user.fields.email') }}{{ Form::text('email',null,['class' => 'width-100']) }}</label>
		<label>{{ trans('user.fields.new_password') }}{{ Form::password('new_password',['class' => 'width-100']) }}</label>
		<h3 class="groups-title"><span>Группы пользователя</span></h3>
		<div class="checkboxs-list">
			
			@foreach(Role::all() as $role)
				<label>{{ Form::checkbox('roles[]',$role->id,in_array($role->id,$cuser->roles()->lists('id'))) }} {{ $role->role }} </label>
			@endforeach
		</div>
		{{ Form::button('Сохранить',array('class' => 'btn btn-orange','type'=>'submit')) }}
	{{ Form::close() }}
	
	</div>
	@endif
	
</div>



	






@stop

