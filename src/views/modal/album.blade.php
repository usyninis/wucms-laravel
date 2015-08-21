<?php /*





print_r(Input::all());

$album = Album::findOrNew(Input::get('id'));

print_r($album);

*/

$album = Album::findOrNew(Input::get('id'));

?>
<div>
	<meta name="wu-modal-title" content="Редактирование альбома">
	<meta name="wu-modal-width" content="300">
	
@if($album->id)
	
{{ Form::model($album,[
	'route'		=> array('admin.albums.update',$album->id),	
	'class'		=> 'js-form forms end',
	'data-pubs'	=> 'notifyModal',
	'method'	=> 'PUT'
	
]) }}

@else

{{ Form::model($album,[
	'route'		=> array('admin.albums.store'),	
	'class'		=> 'js-form forms end',
	'data-pubs'	=> 'notifyModal',
	'method'	=> 'POST'
	
]) }}

@endif

	<label>
	{{ trans('wucms::album.fields.name') }}
	{{ Form::text('name',null,['class'=>'width-100']) }}
	</label>
	<label>
	{{ trans('wucms::album.fields.description') }}
	{{ Form::textarea('description',null,['class'=>'width-100','rows'=>5]) }}
	</label>

{{ Form::button('Сохранить',array('class'	=> 'btn btn-orange','type'=>'submit')) }}
{{ Form::button('Отмена',array('class'	=> 'js-wu-modal-close btn','type'=>'button')) }}

{{ Form::close() }}


</div>