
@if($template = Template::findOrNew(Input::get('id')))
<meta name="wu-modal-title" content="Редактирование шаблона">
	{{ Form::model($template,['data-action'	=> 'templates/save', 'data-pubs' => 'notifyModal reload', 'class' => 'forms end js-form']) }}
		
		{{ Form::hidden('id') }}

		<label>Код{{ Form::text('code',null,['class'=>'width-100']) }}</label>	
		
		<label>Название{{ Form::text('name',null,['class'=>'width-100']) }}</label>
		
		<label>Описание{{ Form::textarea('description',null,['class'=>'width-100','rows'=>5]) }}</label>
		
		{{ Form::button('Сохранить',['type'=>'submit','class'=>'btn btn-orange']) }}
		
		{{ Form::button('Отмена',['class'=>'btn js-wu-modal-close']) }}
		
		@if($template->id)
			<button class="btn right btn-red js-confirm-ajax" data-action="templates/delete" data-pub="notifyModal reload" data-id="{{ $template->id }}" title="Удалить шаблон" type="button"><i class="fa fa-trash-o"></i></button>
		@endif
		
	{{ Form::close() }}

@endif
