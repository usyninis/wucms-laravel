<?php

	$type = Type::find(Input::get('type_id'));
	$type_props = $type->props->lists('id');
	print_r($type_props);
?>
@if($props = Prop::all())

	<div class="group">
	@foreach($props as $prop)
		
		@if(!in_array($prop->id,$type_props))
			<a class="unit" onclick="$('#list-unit-props').">{{ $prop->name }}</a>
			<div id="prop-input-{{ $prop->id }}" class="hide">
				{{ Form::prop($prop,[]) }}
			</div>
		@endif
	@endforeach
	</div>
	
@endif
