
@if($image = GImage::find(Input::get('id')))

	{{ Form::model($image,array(
		'route' => array('admin.images.update',$image->id),		
		
		'class'		=> 'js-form forms',
		'data-pubs'	=> 'notifyModal',
		'method'	=> 'PUT'
	)) }}
	<div class="units-row">
		
		<div class="unit-50">
		{{ HTML::image($image->thumb(400),$image->name,['style'=>'max-width:100%;max-height:300px']) }}
		<br/>{{ $image->path }}
		</div>
		
		<div class="unit-50">
			{{ Form::text('name',null,['class'=>'width-100']) }}
			<br/>
			{{ Form::wuSelector('album_id',Album::all()->lists('name','id'),$image->album_id,['class'=>'width-100']) }}
			<br/>
			{{ Form::textarea('description',null,['class'=>'width-100']) }}
			<br/>
			{{ Form::button('Сохранить',['class'=>'btn btn-orange','type'=>'submit']) }}
			<br/>
			
		</div>	
	</div>
	
	{{ Form::close() }}
@endif
</div>