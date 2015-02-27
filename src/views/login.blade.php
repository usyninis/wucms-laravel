@extends('wucms::template')


@section('content')

	<div style="width:300px;margin:0 auto"> 

    @if (Session::has('flash_error'))
        <div class="tools-alert tools-alert-red">{{ Session::get('flash_error') }}</div>
    @endif

    {{ Form::open(array(
    		'class' => 'forms' 
    	)) }}
		
		
    	
    	<label>
    	Электронная почта <span class="error">{{ $errors->first('email') }}</span>
        {{ Form::text('email', Input::old('username'), [ 
        	'placeholder'	=> 'email',
        	'class'			=> 'width-100'
        ]) }}
        </label>
        <label>
        Пароль <span class="error">{{ $errors->first('password') }}</span>
        {{ Form::password('password', array(
        	'placeholder'	=> 'password',
        	'class'			=> 'width-100'
        )) }}
		</label>
		
		
		<div class="group">
        {{ Form::button('Вход',array(
        	'class'	=> 'btn btn-blue',
        	'type'	=> 'submit'
        )) }}
        {{ HTML::link(URL::route('index'),'Отмена',array(
        	'class'	=> 'btn btn-white'
        )) }}
        </div>

    {{ Form::close() }}
    </div>


@stop