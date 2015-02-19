<?php

	//$prop = Prop::findOrNew(Input::get('id'));
	//$type_props = $type->props->lists('id');
	//print_r($type_props);
?>
@if($prop = Prop::find(Input::get('id')))
	
    {{ Form::model($prop,[ 
		'route' => ['admin.props.update',$prop->id], 
		'data-pubs'=>'notifyModal reload',
		'class' => 'js-form forms-s1 forms end forms-s',
		'method' => 'put',
	]) }}
@elseif($prop = new Prop)
	
    {{ Form::open([
		'route' => 'admin.props.store',
		'data-pubs'=>'notifyModal reload',
		'class' => 'js-form forms-s1 forms end forms-s',
		
	]) }}
@endif

	
	<h3 class="groups-title"><span>Основные данные</span></h3>
	
	<div class="units-row end">
		<div class="unit-50">
		
			<label>Код свойства {{ Form::text('code',null,['class'=>'width-100']) }}</label>
			<label>Название свойства{{ Form::text('name',null,['class'=>'width-100']) }}</label>
			<label>Тип значения свойства{{ Form::wuSelector('type',Prop::typesList(),$prop->type) }}</label>
			<div class="js-list-select {{ ($prop->type=='list' ? '' : 'hide') }}">
			<label>Список элементов
			
				
				{{ Form::select('value',Unit::all()->lists('name','id'),$prop->value) }}
				<?php /*
				<div id="prop-value" class="wu-selector js-wu-modal" data-id="{{ $prop->value }}" data-code="units" data-pub="selector:paste" data-selector="#prop-value">
				{{ Form::hidden('value',$prop->value) }}
					<i class="wu-sel-icon fa fa-ellipsis-h"></i>
					@if($vunit = Unit::find($prop->value))
						<div class="sel-item">{{ $vunit->name }}</div>
					@else
						<div class="sel-item"></div>
					@endif
				</div>
				*/?>
			
			</label>
			</div>
		</div>
		<div class="unit-50">
			
			<label>Описание{{ Form::textarea('description',null,['class'=>'width-100','rows'=>4]) }}</label>
				
			
			
			{{ Form::wuCheckbox('multiple',1,$prop->multiple,['label'=>'Множественное свойство']) }}
			{{ Form::wuCheckbox('required',1,$prop->required,['label'=>'Обязательное свойство']) }}
		
		</div>
	</div>

	

	
	
	<h3 class="groups-title"><span>Типы страниц, содержащие свойство</span></h3>
	
	<div class="checkboxs-list">
	@foreach(Type::all() as $type)
	<label>
		<?php $check = false; ?>
		@foreach($prop->types as $ptype)
			@if($ptype->id==$type->id)
				<?php $check = true; ?>
			@endif
		@endforeach
		{{ Form::checkbox('types['.$type->id.']',1,$check) }}
		{{ $type->name }} 
	</label>
	@endforeach
	</div>
	
	<div class="hr"></div>
	{{ Form::button('Сохранить',array('class' => 'btn large btn-orange','type'=>'submit')) }}
	{{ Form::button('Отмена',array('class' => 'btn large js-wu-modal-close')) }}
	

{{ Form::close() }}