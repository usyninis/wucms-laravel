@extends('admin.template')

@section('head')
{{ HTML::script('packages/jquery/plugins/jquery.nestable.js') }}	
<title>map</title>

<style>
.dd { position: relative; display: block; margin: 0; padding: 15px;list-style: none; font-size: 13px; line-height: 20px; }
.dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
.dd-list .dd-list { padding-left:40px; }
.dd-collapsed .dd-list { display: none; }
.dd-item,
.dd-empty,
.dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }
.dd-handle {display: block;
height: 100%;
width: 30px;left:0;top:0;
color: #333;
text-decoration: none;
position: absolute;
background: rgba(0, 0, 0, 0.07);
font: normal normal normal 14px/1 FontAwesome;
}
.dd-handle:before {
content: "\f0dc";
}
.dd-handle:hover {}
.dd-item > button { left:40px;z-index:1;display: block; position: absolute; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
.dd-item > button[data-action="collapse"]:before { content: '-'; }
.dd-placeholder,
.dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
.dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
    background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                      -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                         -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                              linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-size: 60px 60px;
    background-position: 0 0, 30px 30px;
}
.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
.dd-dragel .dd-unit {
    -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
            box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
}
</style>
<script>

$(function  () {
	


	$(".js-show-form").on('click',function(){
		$(this).hide().next("form").show().find('input').focus();
	}); 
	
	$(".js-close-form").on('click',function(){
		$(this).parents('form').hide().prev(".js-show-form").show();
	});
	$( ".js-sortable" ).sortable({
		items: ".unit:not(.active)",
		placeholder: "unit fake",
		handle:".u-sort",
		connectWith: ".js-sortable",
		update: function(event, ui){
			ui.item.parent("form").submit();
		}
	});
	
$('.dd').nestable({ /* config options */ });

})
</script>
<style>
.dd-unit{position: relative;
background-color: white;
box-shadow: 0 1px 2px rgba(0, 0, 0, 0.09);
padding-left: 100px;
color: #747474;line-height: 30px;text-align: center;
min-height: 30px !important;
display: block;
font-size: 12px;
text-decoration: none;
position: relative;
margin-bottom: 5px;
white-space: nowrap;
text-overflow: ellipsis;
overflow: hidden;}
</style>
@stop

@section('content')
@include('wucms::panel2')

<div class="section-content">

<div class="section-units-list">
<div class="dd">
    <ol class="dd-list">
        <li class="dd-item" data-id="1">
            <div class="dd-unit">
            	<div class="dd-handle"></div>
            	<div class="dd-unit-name">unit 1</div>
            </div>
        </li>
        <li class="dd-item" data-id="2">
            <div class="dd-unit">
            	<div class="dd-handle"></div>
            	<div class="dd-unit-name">unit 2</div>
            </div>
        </li>
        <li class="dd-item" data-id="3">
            
            <div class="dd-unit">
            	<div class="dd-handle"></div>
            	<div class="dd-unit-name">unit 3</div>
            </div>
            <ol class="dd-list">
                <li class="dd-item" data-id="4">
                   <div class="dd-unit">
		            	<div class="dd-handle"></div>
		            	<div class="dd-unit-name">unit 4</div>
		            </div>
                </li>
                <li class="dd-item" data-id="5">
                    <div class="dd-unit">
		            	<div class="dd-handle"></div>
		            	<div class="dd-unit-name">unit 5</div>
		            </div>
                </li>
            </ol>
        </li>
    </ol>
</div>
</div>

	@if(isset($map) && count($map))


		

	
		<div class="section-units-list">
		<div class="units-row units-split" style="padding:1em">
			@foreach($map as $level => $sub_units)
				<?php if($unit->level<($level-1)) continue; ?>
				
				<div class="units-coll unit-33 level-{{ $level }}" data-level="{{ $level }}">
					<div class="units-coll-title">Страницы {{$level}} уровня</div> 
					<?php 
						
						if(empty($sub_units[$unit->id]) && $level==($unit->level+1))
						{
							$sub_units[$unit->id] = [];
						} 
					
					?>

					@foreach($sub_units as $parent_id => $units)
					<?php
						$class = '';
						
						//print_r($unit->parents);
						if($parents = $unit->parents())
						{
						
							foreach ($parents as $i => $parent_unit) 
							{
								
								if($parent_unit->id==$parent_id) $class = 'active';
								//if($parent_unit->id==$parent_id) continue
							}
						}
						
						if($parent_unit = Unit::find($parent_id)) $type_id = $parent_unit->children_type_id;
						else $type_id = Type::defaultType();
						
						if($parent_id==$unit->id OR $level==1) $class = 'active';
					?>
					<div id="sub-units-{{ $parent_id }}" data-id="{{ $parent_id }}" class="sub-units {{ $class }}">
						
						
						{{ Form::open( array('data-action'=>'map/save','data-pubs'=>'notify','method'=>'post','class' => 'js-form js-sortable units-list end')) }}
							{{ Form::hidden('parent_id',$parent_id) }}						
							{{ Form::hidden('level',$level) }}
								
							@foreach($units as $unit_id => $sub_unit2)							
								<a id="unit-{{ $unit_id }}" href="{{ URL::to('admin/units/'.$unit_id) }}" data-id="{{ $unit_id }}" class="unit{{ $sub_unit2->active? '' : ' no-active' }}{{ ($unit_id==$unit->id || $unit_id==$unit->parent_id)?  ' active'  : '' }}">
								<span class="u-id">{{ $unit_id }}</span><span class="u-name">{{ $sub_unit2->name }}</span>
								{{ Form::hidden('units[]',$sub_unit2->id) }}
									@if($sub_unit2->main)
									<span class="u-cntrl u-main"><i class="fa fa-star"></i></span>
									@endif
									
									<span class="u-cntrl u-sort" title="Переместить элемент"><i class="fa fa-sort"></i></span>
								</a>
							@endforeach
							
						{{ Form::close() }}
						
						
						<button class="btn btn-add smaller width-100 js-show-form" type="button"><i class="fa fa-plus"></i>Добавить элемент</button>

						{{ Form::open( array('route' => 'admin.units.store', 'class' => 'hide unit forms ')) }}	
						
							{{ Form::hidden('parent_id',$parent_id) }}
							{{ Form::hidden('type_id',$type_id) }}
							{{ Form::hidden('level',$level) }}
							{{ Form::hidden('sort',count($units)) }}
							<label>{{ Form::text('name',null,array('placeholder'=>trans('admin.fields.name'),'class' => 'input-smaller width-100')) }}</label>						
							{{ Form::button('Добавить',array('class'	=> 'btn btn-blue smaller','type'=>'submit')) }}
							{{ Form::button('Отмена',array('class'	=> 'btn smaller js-close-form','type'=>'button')) }}
						
						{{ Form::close() }}
						
					</div>
						
					
					@endforeach
					
					<?php /*
					@if(empty($sub_units[$unit->id]) && $level==($unit->level+1))
					<div id="sub-units-{{ $unit->id }}" style="border:1px solid #ccc" data-id="{{ $unit->id }}" class="sub-units active">
					sub-units-{{ $unit->id }}
					{{ Form::open( array('data-action'=>'/admin/map','data-pubs'=>'notify','method'=>'post','class' => 'js-form js-sortable')) }}
						{{ Form::hidden('unit_id',$unit->id) }}
						{{ Form::hidden('level',$level) }}
					{{ Form::close() }}	
						
					{{ Form::button('Добавить',array('class' => 'btn smaller width-100 js-show-form')) }}

						{{ Form::open( array('route' => 'admin.units.store', 'class' => 'hide unit forms ')) }}	
						{{ Form::hidden('parent_id',$parent_id) }}
						{{ Form::hidden('level',$level) }}
						<label>{{ Form::text('name',null,array('class' => 'input-smaller width-100')) }}</label>
						
						{{ Form::button('Добавить',array('class'	=> 'btn btn-blue smaller','type'=>'submit')) }}
						{{ Form::button('Отмена',array('class'	=> 'btn smaller js-close-form','type'=>'button')) }}
						
						{{ Form::close() }}
					</div>
					@endif
					*/?>
					
				</div>
			
			@endforeach
		</div>
		</div>
		
		@if(!empty($unit))
		<div class="section-unit-form">
				
				@include('wucms::units.edit', array('unit'=>$unit))
				
		</div>
		@endif
		
	

	@endif

	
</div>

@stop

