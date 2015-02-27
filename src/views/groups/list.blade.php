@extends('wucms::template')

@section('head')
<title>map group</title>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>

Wuapp.sub('document:ready',function(){
	

	$( ".js-sortable" ).sortable({
		//connectWith: ".js-sortable",
		items: ".unit",
		update: function(event, ui){
			//ui.item.parents("form").submit();
			$("#form-group").submit();
			//alert(ui.item.parents("form").prop('class'));
		}
	});
	

});

Wuapp.sub('group:unit.delete',function(d){
	if(d.id)
	$("#unit-"+d.id).fadeOut(200,function(){
		$(this).remove();
		$("#form-group").submit();
	});
});

</script>

@stop

@section('content')
@include('wucms::panel2')
<div class="section-content">
	<div class="units-row end h-h100">
	
		<div class="unit-50 list-el-s1">
		
			<div class="header-s1 group">
				<h3 class="h-title left">Группы страниц</h3>
				<button type="button" class="btn btn-add js-wu-modal right" data-width="300" data-code="group"><i class="fa fa-plus fa-lq"></i></button>
			</div>
			<div id="list-groups" class="js-ajax-section">
			@forelse($groups as $group)
			
				<a class="el-s1{{ object_get($active_group,'id')==$group->id?' active':'' }}" href="{{ route('admin.groups.show',$group->id) }}">
					<div class="el-right-s">	
					{{ Form::delete(null,'<i class="fa fa-trash-o"></i>',['route'=>['admin.groups.destroy',$group->id]],['class'=>'el-btn']) }}
						
					</div>
					<div class="el-name">{{ $group->name }}</div>
					<div class="el-desc">{{ $group->id }} : {{ $group->code }}</div>
				</a>

			@empty
				
				<div class="dfsdfsdf" style="padding:2em;text-align:center;color:#888;font-size:16px;">
					<i class="fa fa-th-large" style="font-size:36px"></i>
					<div style="">Список групп пуст</div>
				</div>	
			
			@endforelse	
			</div>
		</div>
		@if($active_group)
		<div class="unit-50 h-h100" style="background:#f7f7f7;">
			{{ Form::model($active_group,array(
					'route'		=> array('admin.groups.update',$active_group->id),
					'data-pubs' => 'notify',
					'id' 		=> 'form-group',
					'class' 	=> 'js-form unit-d-units-list end forms',
					'method'	=> 'put'
				)) }}
			{{ Form::hidden('group_id',$active_group->id) }}
			
				<div class="header-s2 group">
					
					<div class="right">
						<span class="btn-single">
							<button class="btn js-wu-modal" type="button" data-code="group" data-id="{{ $active_group->id }}" title="Редактировать группу"><i class="fa fa-pencil"></i></button>
						</span>
						<span class="btn-single">
							<button class="btn js-wu-modal" type="button" data-code="group_list" data-id="{{ $active_group->id }}"><i class="fa fa-plus"></i> Добавить страницы</button>
						</span>
					</div>
					<h1 id="group-title" class="h-title js-ajax-section">{{ $active_group->name }}</h1>
					
				</div>
				<div class="sort-by-sort">
				<div class="js-sortable unit-d-units-list">
					<div id="list-group-units" class="js-ajax-section">
					
						
						
						@forelse($active_group->units as $unit)
							<div id="unit-{{ $unit->id }}" class="unit">
							{{ Form::hidden('units[]',$unit->id) }}
							<a class="btn right js-pub" data-pub="group:unit.delete" data-id="{{ $unit->id }}"><i class="fa fa-close"></i></a>
								<span class="u-sort ui-sortable-handle" title="Изменить порядок страниц"><i class="fa fa-ellipsis-v"></i></span>
								<span class="u-name">{{ $unit->name }}</span>
								<span class="u-url">{{ $unit->url }}</span>
								
							</div>
						@empty
						
							@include('wucms::ui.empty',['text'=>'В группу не добавлены страницы'])
							
						@endforelse
					</div>
					
				
				</div>
				</div>
			
			{{ Form::close() }}
		</div>
		@endif
	</div>
</div>

<script>
Wuapp.sub('groups/toggle_unit',function(d){
	//Wuapp.pub('reload');
	
});
</script>

@stop

