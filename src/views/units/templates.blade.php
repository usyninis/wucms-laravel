@extends('wucms::template')

@section('content')
@include('wucms::panel2')
<div class="section-content">
<div class="units-row end h-h100">
	<div class="unit-50 list-el-s1">

		<div class="header-s1 group">
			<h3 class="h-title left">Шаблоны</h3>
			<a class="btn btn-add right js-wu-modal" data-title="Создание шаблона" data-width="350" data-code="template"><i class="fa fa-plus"></i> Добавить шаблон</a>
		</div>
	
		<div id="list-templates" class="js-ajax-section">
			
				
		@if($templates = Template::all())
			@if( ! $templates->isEmpty())		
				@foreach($templates as $template)
				<div  class="el-s1 js-wu-modal" data-code="template" data-title="Редактирование шаблона" data-width="350" data-id="{{ $template->id }}">
				<div class="el-right-s">	
					<div class="el-btn js-confirm-ajax" title="Удалить шаблон" data-action="templates/delete" data-pub="notify reload" data-id="{{ $template->id }}"><i class="fa fa-trash-o"></i></div>
				</div>	
					<div class="el-name">{{ $template->name }}</div>
					<div class="el-desc">{{ $template->id }} - {{ $template->code }}</div>
				</div>
				@endforeach	
			@else
				@include('admin.ui.empty')
			@endif
		@endif
			
		</div>
	

	</div>
</div>
</div>
@stop