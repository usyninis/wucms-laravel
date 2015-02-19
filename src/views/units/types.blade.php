@extends('wucms::template')

@section('content')
@include('wucms::panel2')
<div class="section-content">
<div class="units-row end h-h100">
	
	<div class="unit-50 list-el-s1">	


		<div class="header-s1 group">
			<h3 class="h-title left">Типы страниц</h3>
			<a class="btn btn-add right js-wu-modal" data-title="Создание типа" data-width="350" data-code="type"><i class="fa fa-plus"></i> Добавить тип</a>
		</div>
		
		<div id="list-types" class="js-ajax-section list-el-s1">

				
		@if($types = Type::with('template')->get())
			@foreach($types as $type)
			<div class="el-s1 js-wu-modal"  data-code="type" data-title="Редактирование типа" data-width="350" data-id="{{ $type->id }}">
			<div class="el-right-s">	
				<div class="js-confirm-ajax el-btn" data-action="types/delete" data-pub="notify reload" data-id="{{ $type->id }}"><i class="fa fa-trash-o"></i></div>
			</div>
				<div class="el-name">{{ $type->name }}</div>
				<div class="el-desc">{{ $type->id }} - {{ $type->code }}</div>
			
			
			
				
			</div>
			@endforeach
		@endif
			
		</div>
		

	</div>
</div>
</div>




@stop