@extends('admin.template')



@section('content')

<style>
.form-settings{}

.form-settings input{background: transparent;
border-color: transparent;
cursor: pointer;
color: #F78254;
font-weight: bold;
text-decoration: underline;}


.form-settings textarea:focus,
.form-settings input:focus{border-color: rgb(204, 204, 204);
background: #fff;
color: #444;
font-weight: normal;
text-decoration: none;
cursor: inherit;}
.form-settings input:hover{color: #333333;}
.form-settings textarea:focus{height:auto;}

.table-settings{font-size:12px;}
.table-settings td{}
.table-settings .edit-value{cursor: pointer;
color: #F78254;
font-weight: bold;
text-decoration: underline;}
.table-settings .edit-value:hover{color: #333333;}

</style>

@if($settings = Setting::all())



<div class="units-row end h-h100">	

	<div class="unit-50 list-el-s1">	
		<div class="header-s1 group">
			<h3 class="h-title left">Настройки</h3>
			<button type="button" class="btn btn-add right js-wu-modal" data-width="400" data-code="setting"><i class="fa fa-plus"></i> Добавить настройку</button>
		</div>
		
		<table id="table-settings" class="js-ajax-section table-settings">			
		@foreach($settings as $setting)
		<tr>
			<td class="width-30">{{{ $setting->name }}}</td>
			<td class="width-60">
				{{ Form::open(['data-action'	=> 'settings/saveValue','data-pubs'=> 'notify','class'=>'js-form form-settings end','data-submit-onchange'=>true]) }}
				{{ Form::hidden('id',$setting->id) }}
				@if($setting->type=='checkbox')	
					{{ Form::wuCheckbox('value_int',1,$setting->value,['class'=>'width-100']) }}
				@elseif($setting->type=='text')
					<a id="edit-setting-{{ $setting->id }}" class="edit-value" onclick="$('#setting-{{ $setting->id }}-value').show().find('textarea').focus();$(this).hide()">Изменить значение</a>
					<div id="setting-{{ $setting->id }}-value" onFocusOut="$(this).hide();$('#edit-setting-{{ $setting->id }}').show()" class="hide">
					{{ Form::textarea('value_text',$setting->value,['rows'=>'10','class'=>'width-100','placeholder'=>'Изменить значение']) }}
					</div>
				@else
					{{ Form::text($setting->value_key,$setting->value,['placeholder'=>'Изменить значение','class'=>'width-100']) }}
				@endif
				{{ Form::close() }}
			</td>			
			<td class="width-10"><a class="btn js-wu-modal" href="#" data-width="400" data-code="setting" data-id="{{ $setting->id }}"><i class="fa fa-pencil"></i></a></td>
		</tr>
		@endforeach
		</table>
		
		
	</div>
	
	

	

</div>

@endif


@stop