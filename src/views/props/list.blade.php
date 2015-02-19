@extends('wucms::template')


@section('content')
@include('wucms::panel2')

<div class="section-content">
	<div class="units-row end h-h100">
		<div class="unit-50 list-el-s1">	
			
		
		<div class="header-s1 group">
			
				{{ Form::open(['class'=>'left end','method'=>'GET','onchange'=>'$(this).submit()']) }}
					{{ Form::wuSelector('type',([0=>'Все']+Type::lists('name','id')),(int)Input::get('type')) }}
				{{ Form::close() }}
			
			
				<button type="button" class="btn right btn-add js-wu-modal" data-title="Добавить новое свойство" data-code="prop"><i class="fa fa-plus fa-lq"></i> Добавить свойство</button>
			
		</div>	
		<div id="list-props" class="js-ajax-section">
		
		{{ Form::open(array(
			'route'		=> array('admin.props.store'),
					
			'id'		=> 'create-prop-form',
			'class'		=> 'js-form forms hide',
			'data-pubs'	=> 'notify'
			))
		}}
			<label>Код свойства {{ Form::text('code',null,['class'=>'width-50']) }}</label>
			<label>Название свойства{{ Form::text('name',null,['class'=>'width-50']) }}</label>
			
			<label>Тип значения свойства{{ Form::wuSelector('type',Prop::typesList()) }}</label>
				
			{{ Form::button('Добавить',array('class'	=> 'btn btn-orange','type'=>'submit')) }}
			{{ Form::button('Отмена',array('data-show'=>'#create-prop-btn','data-hide'=>'#create-prop-form','class'	=> 'js-show btn btn-gray')) }}
		{{ Form::close() }}
		
		<?php
		
			$props->load('types');
		
		
		
			$props = $props->filter(function($prop)
			{
				if(Input::get('type')) return $prop->types->contains(Input::get('type'));
				return true;
				//return $user->isAdmin();
			});
		?>
		
		@forelse($props as $prop)
		
		<div class="el-s1 js-wu-modal" data-title="Редактировать свойство" data-code="prop" data-id="{{ $prop->id }}">
		<div class="el-left-s">
			<div class="el-btn"><i class="fa fa-ellipsis-v"></i></div>
		</div>
			<div class="el-name">{{ $prop->name }}</div>
			<div class="el-desc">{{ $prop->description }}</div>
		</div>
		@empty
			@include('admin.ui.empty')		
		@endforelse
		
		</div>
		</div>
		
		<div class="unit-60" style="padding:1em">
		@if(!empty($aprop))
				{{ Form::model($aprop,array(
					'route'		=> array('admin.props.update',$aprop->id),
						
					'class'		=> 'js-form forms forms-s1',
					'data-pubs'	=> 'notify',
					'method'	=> 'PUT'
					))
				}}
					<h2 class="form-title">Редактирование свойства</h2>
					<h3 class="groups-title"><span>Основные данные</span></h3>
					
					<label class="width-50">Код свойства {{ Form::text('code',null,['class'=>'width-100']) }}</label>
					<label class="width-50">Название свойства{{ Form::text('name',null,['class'=>'width-100']) }}</label>
					<label class="width-50">Описание{{ Form::textarea('description',null,['class'=>'width-100','rows'=>4]) }}</label>
					<label class="width-50">Тип значения свойства{{ Form::wuSelector('type',Prop::typesList(),$aprop->type) }}</label>
					
					<div class="js-list-select {{ ($aprop->type=='list' ? '' : 'hide') }}">
					<label>Список элементов
					
						<div id="prop-value" class="wu-selector js-wu-modal" data-id="{{ $aprop->value }}" data-code="units" data-pub="selector:paste" data-selector="#prop-value">
						{{ Form::hidden('value',$aprop->value) }}
							<i class="wu-sel-icon fa fa-ellipsis-h"></i>
							@if($vunit = Unit::find($aprop->value))
								<div class="sel-item">{{ $vunit->name }}</div>
							@else
								<div class="sel-item"></div>
							@endif
						</div>
					
					</label>
					</div>
					
					{{ Form::wuCheckbox('multiple',1,$aprop->multiple,['label'=>'Множественное (может иметь несколько значений)']) }}
					{{ Form::wuCheckbox('required',1,$aprop->required,['label'=>'Обязательное свойство']) }}
					<h3 class="groups-title"><span>Типы страниц, содержащие свойство</span></h3>
					
					<div class="checkboxs-list">
					@foreach(Type::all() as $type)
					<label>
						<?php $check = false; ?>
						@foreach($aprop->types as $ptype)
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
					{{ Form::button('Сохранить',array('class' => 'btn big btn-orange','type'=>'submit')) }}
					

				{{ Form::close() }}
		@endif
		
		</div>
</div>
</div>
<script>

$(function(){

	$(document).on("change","input[name=type]",function(){
		if($(this).val()=='list') $(".js-list-select").show();
		else $(".js-list-select").hide();
		//alert($(this).val());
	});
});
</script>
	






@stop

