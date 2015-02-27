<?php
	
	$group = Group::find(Input::get('id'));
	$group_units = $group->units->lists('id');
	//$unit = Unit::find(Input::get('id'));
	
	$list_unit = Unit::find(Input::get('list_id'));

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


<meta name="wu-modal-title" content="Список страниц группы">
<meta name="wu-modal-width" content="400">
	
<div class="sdfdsdf unit-d-units-list units-row">

@if($list_unit)
	<div class="units-row" style="margin-bottom: .8em;
padding-bottom: .8em;
border-bottom: 1px solid #D5D5D5;">
	
		<a class="unit js-wu-modal" data-code="group_list" data-id="{{ $group->id }}" data-list_id="{{ $list_unit->parent_id }}" style="float:left;width:60px;text-align:center;margin-right:10px;">
			<div class="u-name" style="line-height:200%"> <i class="fa fa-chevron-left"></i></div>
		</a>
		<a class="unit active" >
			
			<div class="u-name">{{ $list_unit->name }}</div>
			<div class="u-url">{{ $list_unit->url }}</div>
		</a>
	</div>
@endif



@if($units = Unit::whereParentId((int)Input::get('list_id'))->get())

	@if($units->count())
	 
		@foreach($units as $sunit)
					
			<div class="unit">
			<a href="{{ url('admin/ajax/groups/toggle_unit') }}" onclick="$(this).toggleClass('btn-orange');" data-pub="reload group:unit.toggle" style="float:left;margin-right:1em;padding: .5em 1em;" data-group_id="{{ $group->id }}" data-unit_id="{{ $sunit->id }}" class="btn btn-unit-status {{ in_array($sunit->id,$group_units) ? '' : 'btn-orange' }} small js-ajax">
				<span class="status-u-a">Добавить</span><span class="status-u-d">Добавлен</span>
			</a>
			<div class="js-wu-modal" data-code="group_list" data-id="{{ $group->id }}" data-list_id="{{ $sunit->id }}">
				<div class="u-name">{{ $sunit->name }}</div>
				<div class="u-url">{{ $sunit->url }}</div>
			</div>	
			</div>
			
		@endforeach

	@else

		@include('wucms::ui.empty')	

	@endif

@endif

	

</div>

<button type="button" class="btn small js-wu-modal-close">Закрыть</button>

<style>
.sdfdsdf{min-height:400px;background:#e7e7e7;padding:1em}
.sdfdsdf .unit{cursor:pointer}
.dsfd{position:relative;}
.dsfd .unit{padding-left:54px;cursor:pointer}
.sdfdsdf .unit .btn-unit-status .status-u-a{display:none}
.sdfdsdf .unit .btn-unit-status .status-u-d{display:inline}
.sdfdsdf .unit .btn-unit-status.btn-orange .status-u-a{display:inline}
.sdfdsdf .unit .btn-unit-status.btn-orange .status-u-d{display:none}


.dsfd .btn:hover{background:#E2612E;color:#fff}
</style>

