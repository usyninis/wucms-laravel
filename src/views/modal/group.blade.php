@if($group = Group::findOrNew(Input::get('id')))
	<meta name="wu-modal-title" content="Редактирование группы">
	<meta name="wu-modal-width" content="300">
	{{ Form::model($group,array(
		'route'	=> array('admin.groups.store',$group->id),
		'data-pubs' => 'notifyModal reload',
		'class' 	=> 'js-form end forms forms-s1'
	)) }}	
		{{ Form::hidden('id') }}
		
		<label>{{ trans('wucms::group.fields.code') }}{{ Form::text('code',null,array('class' => 'input-flat width-100')) }}</label>
		<label>{{ trans('wucms::group.fields.name') }}{{ Form::text('name',null,array('class' => 'width-100')) }}</label>		
		
	
		<div class="hr"></div>
		
		{{ Form::button('Сохранить',array('class'	=> 'btn btn-orange','type'=>'submit')) }}
		{{ Form::button('Отмена',array('class'	=> 'js-wu-modal-close btn')) }}
		
		
	{{ Form::close() }}

@endif
