<?php
	
	$unit = Unit::find(Input::get('id'));
	
	$list_unit = Unit::find(Input::get('listId'));

	//$active_id = Input::get('activeId');//?:$unit->parent_id;
	
	if($list_unit) 
	{
		
		$active_name = ' в раздел «'.$list_unit->name.'»';
		
	}
	else
	{	
		
		//$active_unit = false;
		$active_name = 'на верхний уровень';
		
	}
	
	//$active_list = Unit::whereParentId($active_id)->get(); */
	
	
	
?>

<div class="section-help">Выберите раздел, в который необходимо поместить страницу</div>
<div class="sdfdsdf unit-d-units-list units-row">

@if($list_unit)
	<div class="units-row">
	
		<a class="unit js-wu-modal" data-width="400" data-code="units2" data-id="{{ $unit->id }}" data-list-id="{{ $list_unit->parent_id }}" style="float:left;width:60px;text-align:center;margin-right:10px;">
			<div class="u-name" style="line-height:200%"> <i class="fa fa-chevron-left"></i></div>
		</a>
		<a class="unit active js-wu-modal" data-width="400" data-code="units2" data-id="{{ $unit->id }}" data-list-id="{{ $list_unit->parent_id }}">
			
			<div class="u-name">{{ $list_unit->name }}</div>
			<div class="u-url">{{ $list_unit->url }}</div>
		</a>
	</div>
@endif

@foreach(Unit::whereParentId(Input::get('listId'))->get() as $sunit)
<?php if($sunit->id==$unit->id) continue; ?>
									


		
		<a data-id="{{ $unit->id }}" class="unit js-wu-modal" data-width="400" data-code="units2" data-list-id="{{ $sunit->id }}">

			<div class="u-name">{{ $sunit->name }}</div>
			<div class="u-url">{{ $sunit->url }}</div>
			
		</a>
		
		
	
	
@endforeach

</div>
{{ Form::open(['class'=>'forms end js-form','data-action'=>'units/move','data-pubs'=>'notifyModal reload']) }}
{{ Form::hidden('parent_id',Input::get('listId')) }}
{{ Form::hidden('unit_id',$unit->id) }}
<button type="submit" class="btn small btn-orange">Переместить {{ $active_name }}</button>
<button type="button" class="btn small js-wu-modal-close">Отмена</button>
{{ Form::close() }}
<style>
.sdfdsdf{min-height:400px;background:#e7e7e7;padding:1em}
.sdfdsdf .unit{cursor:pointer}
.dsfd{position:relative;}
.dsfd .unit{padding-left:54px;cursor:pointer}


.dsfd .btn:hover{background:#E2612E;color:#fff}
</style>