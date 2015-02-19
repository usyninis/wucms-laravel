@if($album = Album::findOrNew(Input::get('id'))
	
	
{{ Form::model($album,array(
	'route'		=> array('admin.albums.update',$album->id),
	'id'		=> 'album-form',		
	'class'		=> 'js-form forms hide',
	'data-pubs'	=> 'notify',
	'method'	=> 'PUT',
	))
}}

	{{ Form::text('name',null,['class'=>'width-100','placeholder'=>'Название альбома']) }}


{{ Form::button('Сохранить',array('class'	=> 'btn btn-orange','type'=>'submit')) }}
{{ Form::button('Отмена',array('class'	=> 'js-show btn','data-hide'=>'#album-form','data-show'=>'#album-header','type'=>'button')) }}

{{ Form::close() }}

@endif