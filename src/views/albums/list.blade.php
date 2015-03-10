@extends('wucms::template')

@section('head')
<title>map</title>

@stop

@section('content')


<div class="units-row units-split end h-h100">

<div class="unit-20 list-el-s1">


	<div class="header-s1 group">
		<h3 class="h-title left">Альбомы</h3>
		{{ Form::button('<i class="fa fa-plus"></i>',['class'=>'right btn btn-add js-wu-modal','data-code'=>'album']) }}
	</div>
	
		

	

	
	
	

	
			<a class="el-s1 {{ ( ! Request::segment(3)?'active':'') }}" href="{{ route('admin.albums.index') }}">				
				<div class="el-name">Все фотографии</div>
				<div class="el-desc">{{ Image::count() }} фото</div>
			</a>

		@foreach($albums as $salbum)
			
			<a class="el-s1 {{ ($salbum->id==Request::segment(3)?'active':'') }}" href="{{ url('admin/albums/'.$salbum->id) }}">
			
				<div class="el-name">{{ $salbum->name }}</div>
				<div class="el-desc">{{ $salbum->count }} фото</div>
				
			</a>

		@endforeach
	
	
	
</div>

<div class="unit-80">
	
		
			@include('wucms::albums.album')
		
	
</div>

</div>

@stop

