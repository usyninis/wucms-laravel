@extends('wucms::template')

@section('head')
<title>map</title>


<script>

$(function  () {
	


	
	$( ".js-sortable" ).sortable({
		items: ".unit",
		placeholder: "unit fake",
		handle:".u-sort",
		connectWith: ".js-sortable",
		update: function(event, ui){
			ui.item.parent("form").submit();
			//alert(ui.item.html());
		}
	});
	


})
</script>

@stop

@section('content')
@include('wucms::panel2')

<div class="section-content">
<div class="unit-d-w">
<div class="unit-d">
	
	
	
	{{--
	<div class="section-units-tools units-row end">
		
		<div class="unit-70">
			<div class="s-search">
				<i class="fa fa-search"></i>
				{{ Form::text('search','',['class'=>'width-100','autocomplete'=>'off','placeholder'=>'Поиск страницы...']) }}
			</div>
		</div>
		<div class="unit-30">
			<button class="btn btn-add width-100"><i class="fa fa-plus"></i> Добавить страницу</button>
		</div>
	</div>
	--}}
	{{--		
	<div class="unit-d-header">
	@if(!empty($unit))
		<div class="group"> 
			@if($unit->parent_id)
			<a class="btn left" href="{{ URL::to('admin/units/'.$unit->parent_id) }}"><i class="fa fa-chevron-left"></i></a>
			@else
			<a class="btn left" href="{{ URL::to('admin/units') }}"><i class="fa fa-chevron-left"></i></a>
			@endif
			<div class="unit-name">{{ $unit->name }}</div>
		</div>
		@endif
	</div>
	--}}
	

	<style>
	
	.dfsdsas{display: block;
position: absolute;
width: 50px;
background: #fff;
border: 1px solid #D8D8D8;
top: 10px;
text-align: center;
padding: 10px;z-index:1;
color: #5F5F5F;
border-radius: 2px;}
	</style>
	

	<div class="admin-breadcrumbs">
	<div class="group">
		
		
		<a class="home{{ empty($unit) ? ' active' : (Input::get('parent_id')=='home'?' last':'') }}" href="/admin/units"><i class="fa fa-home"></i></a>

		@if(!empty($parent_unit))
		
		
		
		@if($parents = $parent_unit->parents())
		
			@foreach($parents as $punit)
		
			<a href="/admin/units/{{ $punit->id }}">
				<span class="a-name">{{ $punit->name }}</span>
				<span class="a-text">Всего {{ $punit->count }} страниц</span>
			</a>
			
			@endforeach
			
		@endif
		
		<a class="last {{ $parent_unit->id==$unit->id?'active':'' }}" href="/admin/units/{{ $parent_unit->id }}">
			<span class="a-name">{{ $parent_unit->name }}</span>
			<span class="a-text">Всего {{ $parent_unit->count }} страниц</span>
		</a>
		@else
		
		@endif
	
	</div>
	</div>

	

	
	
	<div class="unit-d-units-list">
	
	
		{{--
			@if(!empty($unit))
			
			@if($parent = $unit->parent)
				<a class="dfsdsas" href="/admin/units/{{ $parent->id }}"><i class="fa fa-chevron-left"></i></a>
			@else
			
				<a class="dfsdsas" href="/admin/units"><i class="fa fa-chevron-left"></i></a>
			@endif
			
		@endif
		--}}
	

	@if( ! $units->isEmpty())
	<div class="section-list-tools units-row">
	

		
		<div class="unit-50">
			<button class="btn btn-orange small js-show" data-show="#create-unit-form" data-hide=".section-list-tools" type="button"><i class="fa fa-plus"></i> Добавить страницу</button>
		</div>
		
		<div class="unit-50">
			<span class="btn-group btn-group-sort right">
				<a class="btn btn-view{{ $sort=='sort' ? ' btn-active' : '' }}" data-param="sort"><i class="fa fa-reorder"></i></a>
				<a class="btn btn-view{{ $sort=='public_date' ? ' btn-active' : '' }}" data-param="public_date"><i class="fa fa-clock-o"></i></a>
			</span>
		</div>
		
	</div>
	@endif
	
	<script>
	$(function(){
		
		
		
		$(".btn-group-sort a").click(function(){
			if($(this).hasClass('btn-active')) return false;
			var $btn = $(this);
			$btn.addClass('btn-active').siblings().removeClass('btn-active');
			
			var $elements = $('#sfdfs .unit');
			//var $target = $('.sorting ul');
			var param = $btn.data('param');
			var a = [];
			
			$elements.each(function (e) {
				a.push($(this).data(param));
			});
			// alert(a);
			a.sort(function(a,b){
				return a-b;
			
			});
			$.get('',{sort:param});
			//$('#sfdfs').prop('class','sort-by-'+param);
			//$elements.detach().appendTo($target);
			for(i=0; i < a.length; i++)
			{	
				var $item = $('#sfdfs .unit[data-'+param+'="'+a[i]+'"]');
				if($item.length)
					$item.detach().appendTo($('#sfdfs'));
				//alert(a[i]);
			}
			$("#dfsdfsdfsdf").prop("class","sort-by-"+param);
			
		});
		
		
		
		
	});
		
		
	Wuapp.sub('unit:move',function(d){
		alert('Функция недоступна');
	});
	
	
		
	
	</script>
	<style>
	.create-unit-form{padding: 12px 15px;
background: #fff;
font-size: 12px;
border-radius: 2px;}
	</style>
	
	{{ Form::open( array('route' => 'admin.units.store', 'id'=>'create-unit-form','data-pubs'=>'notify','class' => 'hide js-form create-unit-form forms ')) }}	
		@if(!empty($parent_unit))		
			{{ Form::hidden('parent_id',$parent_unit->id) }}
			{{ Form::hidden('type_id',$parent_unit->children_type_id) }}
		@else
			{{ Form::hidden('parent_id',0) }}
			{{ Form::hidden('type_id',Type::defaultType()) }}		
		@endif
		{{ Form::hidden('level',1) }}
		{{ Form::hidden('sort',9999) }}
		<label>{{ trans('admin.fields.name') }} {{ Form::text('name',null,array('placeholder'=>'','class' => 'input-smaller width-100')) }}</label>						
		{{ Form::button('Добавить',array('class'	=> 'btn btn-blue smaller','type'=>'submit')) }}
		{{ Form::button('Отмена',array('class'	=> 'btn smaller js-show','data-show'=>'.dfsdfsdf,.section-list-tools','data-hide'=>'#create-unit-form','type'=>'button')) }}

	{{ Form::close() }}
	
	@if( ! $units->isEmpty())
		<div id="dfsdfsdfsdf" class="sort-by-{{ $sort }} js-ajax-section">
		{{ Form::open( array('id'=>'sfdfs','data-action'=>'map/save','data-pubs'=>'notify','method'=>'post','class' => 'js-form js-sortable')) }}
		@foreach($units as $cunit)
			<div class="unit{{ $cunit->active? '' : ' noactive' }}{{ ( ! empty($unit) && $unit->id==$cunit->id )? ' active' : '' }}" data-sort="{{ $cunit->sort }}" data-public_date="{{ strtotime($cunit->public_date)?:strtotime($cunit->created_at) }}">
				
				<span class="u-sort ui-sortable-handle" title="Изменить порядок страниц"><i class="fa fa-ellipsis-v"></i></span>
				<span class="u-date" title="Дата публикации">
					<span class="u-date-d">{{ date('d M',strtotime($cunit->public_date)) }}</span>
					<span class="u-date-m">{{ date('Y',strtotime($cunit->public_date)) }}</span>
				</span>
				
				{{-- <span class="u-icon" style="background:#{{ $unit->type_id*111 }}"></span> --}}
				<a href="{{ URL::to('admin/units/'.$cunit->id.'?parent_id='.($cunit->parent_id?:'home')) }}">
				<span class="u-name">{{ $cunit->name }}</span>
				<span class="u-url">{{ $cunit->url }}</span>
				</a>
				{{ Form::hidden('units[]',$cunit->id) }}
			
					
					
						
				<a class="u-move js-wu-modal" data-code="units2" data-width="400" data-id="{{ $cunit->id }}" data-list-id="{{ $cunit->parent_id }}" title="Переместить страницу"> <i class="fa fa-share"></i></a>
				<a class="u-down" href="{{ URL::to('admin/units/'.$cunit->id) }}"><span class="">{{ $cunit->count ?: '<i class="fa fa-angle-right"></i>' }}</span> </a>
					
			
			</div>
		@endforeach
		{{ Form::close() }}
		</div>
	@else
		<div class="dfsdfsdf" style="padding:2em;text-align:center;color:#888;font-size:16px;">
			<i class="fa fa-flash" style="font-size:36px"></i>
			<div style="">list is empty</div>
			<a class="btn btn-orange js-show small" data-show="#create-unit-form" data-hide=".dfsdfsdf"><i class="fa fa-plus"></i> Добавить страницу</a>
			
		</div>
	@endif
	
	
	</div>
</div>
</div>
</div>




	
		@if(!empty($unit))
		<div class="section-unit-form">
				
				@include('wucms::units.edit', array('unit'=>$unit))
				
		</div>
		@else
		<div class="section-unit-form">
		

			<div style="padding:2em;text-align:center;color:#888;font-size:16px;border-left:1px solid #ccc;height:100%;position:relative">
				<i class="fa fa-edit" style="font-size:36px"></i>
				<div style="">Выберите страницу для редактирования</div>
			</div>
		
		</div>
		@endif
		
	

	


@stop

