<div class="sdfdsdf">
@foreach(Unit::map() as $level => $level_units)

									
	@foreach($level_units as $parent_id => $units)
	<?php
		$class = ( ! $parent_id? '' : 'hide' );
		if($active_id = Input::get('id'))
		{
			$class = ( array_key_exists($active_id,(array)$units) ? '' : 'hide' ); 
		}
	?>
		<div id="level-{{ $level }}-unit-{{ $parent_id }}" class="{{ $class }}">
		@if($parent = Unit::find($parent_id))
		<a class="unit active js-show" data-show="#level-{{ $level-1 }}-unit-{{ Unit::find($parent_id)->parent_id }}" data-hide="#level-{{ $level }}-unit-{{ $parent_id }}"><i class="fa fa-chevron-left"></i> {{ $parent->name }}</a>
		@else
		<div class="section-help">Выберите страницу из списка</div>
		@endif
		<div class="js-sortable" style="padding:.5em 0">
		@foreach($units as $unit)
		<?php if(Input::get('hideId')==$unit->id) continue;?>
		<div class="dsfd group">
		
		<a id="unit-{{ $unit->id }}" data-id="{{ $unit->id }}" class="unit js-show" data-hide="#level-{{ $level }}-unit-{{ $parent_id }}" data-show="#level-{{ $level+1 }}-unit-{{ $unit->id }}">
<button class="btn btn-small js-pub" data-pub="{{ Input::get('pub') }}" data-selector="{{ Input::get('selector') }}" data-id="{{ $unit->id }}" data-name="{{ $unit->name }}" type="button"><i class="fa fa-check"></i></button>
			{{ $unit->name }} {{ Form::hidden('units[]',$unit->id) }}
										<div class="right"><i class="fa fa-chevron-right"></i></div>
		</a>
		
		</div>
		@endforeach
		</div>
		</div>
	@endforeach
	
@endforeach
</div>
<style>
.sdfdsdf{height:300px;overflow:auto}
.sdfdsdf .unit{cursor:pointer}
.dsfd{position:relative;}
.dsfd .unit{padding-left:54px;cursor:pointer}
.dsfd .btn{display: block;
float: left;position:absolute;left:0;top:0;
height: 34px;
line-height: 34px;
padding: 0;
width: 34px;}

.dsfd .btn:hover{background:#E2612E;color:#fff}
</style>