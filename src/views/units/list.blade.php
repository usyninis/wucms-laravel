
@foreach($map as $level => $level_units)

								
	@foreach($level_units as $units)					
		@foreach($units as $unit)					
		<a id="unit-{{ $unit->id }}" href="#" data-id="{{ $unit->id }}" class="unit">
							{{ $unit->id }} : {{ $unit->name }}
		</a>
		@endforeach
	@endforeach
	
@endforeach
