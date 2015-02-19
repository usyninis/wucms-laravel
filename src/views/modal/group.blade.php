
@if($group = Group::findOrNew(Input::get('id')))

	{{ Form::model($group,array(
		'route'	=> array('admin.groups.store',$group->id),
		'data-pubs' => 'notifyModal reload',
		'class' 	=> 'js-form end forms'
	)) }}	
		{{ Form::hidden('id') }}
		
		<label>Code{{ Form::text('code',null,array('class' => 'input-flat width-100')) }}</label>
		<label>Name{{ Form::text('name',null,array('class' => 'width-100')) }}</label>		
		
	
		
		
		{{ Form::button('Сохранить',array('class'	=> 'btn btn-orange','type'=>'submit')) }}
		{{ Form::button('Отмена',array('class'	=> 'js-wu-modal-close btn')) }}
		
		
	{{ Form::close() }}

@endif
