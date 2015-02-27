@extends('wucms::template')

@section('head')
<title>map</title>

@stop

@section('content')


<div class="units-row units-split end h-h100">

<div class="unit-20 list-el-s1">


	<div class="header-s1 group">
		<h3 class="h-title left">Альбомы</h3>
		{{ Form::button('<i class="fa fa-plus"></i>',['id'=>'new-alb-btn','class'=>'right btn btn-add js-show','data-show'=>'#new-alb-form','data-hide'=>'#new-alb-btn']) }}
	</div>
	
		

		{{ Form::open(['id'=>'new-alb-form','route' => 'admin.albums.store','class'		=> 'forms hide en']) }}
			<label>{{ Form::text('name',null,['class'=>'width-100 input-small','required'=>true]) }}</label>

			{{ Form::button('Добавить',['type'=>'submit','class'=>'btn btn-orange small']) }}
			{{ Form::button('Отмена',['class'=>'btn btn-gray small js-show','data-hide'=>'#new-alb-form','data-show'=>'#new-alb-btn']) }}
			
		{{ Form::close() }}

	
	
	

	
			<a class="el-s1 {{ ( ! Request::segment(3)?'active':'') }}" href="{{ route('admin.albums.index') }}">
			<div class="el-right-s">
				<span class="badge badge-small">{{ Image::count() }}</span>
			</div>
			<div class="el-name">Все фотографии</div>
			</a>

		@foreach($albums as $salbum)
			
			<a class="el-s1 {{ ($salbum->id==Request::segment(3)?'active':'') }}" href="{{ url('admin/albums/'.$salbum->id) }}">
			<div class="el-right-s">
				<span class="badge badge-small">{{ $salbum->count }}</span>
			</div>
				<div class="el-name">{{ $salbum->name }}</div>
				<div class="el-description">{{ $salbum->description }}</div>
				
			</a>

		@endforeach
	
	
	
</div>

<div class="unit-80">
	
		
			@include('wucms::albums.album')
		
	
</div>

</div>

@stop

