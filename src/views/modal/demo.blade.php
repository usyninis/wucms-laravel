
@if($images = GImage::orderBy('id','DESC')->get())

	<div class="group">
	
	<div class="gallery-photo">
		<div class="file-upload-form-fake"><div class="f-text">Загрузить фото</div></div>
		{{ Form::open(array(
			'route'		=> array('admin.albums.update'),
			'files'		=> true,
			'class'		=> 'js-form forms js-upload-form file-upload-form',
			'data-pubs'	=> 'notify',
			'method'	=> 'PUT'))
		}}
		{{ Form::hidden('album_id',0) }}

			{{ Form::file('images[]',['class'=>'file-upload-input','accept'=>'image/jpeg','min'=>1,'max'=>50,'multiple'=>true]) }}
			
			

		{{ Form::close() }}
	</div>
	
	@foreach($images as $image)
	
		<div class="gallery-photo js-pub" data-change-id="{{ Input::get('id') }}" data-pub="{{ Input::get('pub') }}" data-id="{{ $image->id }}" data-src="{{ $image->src }}">{{ HTML::image($image->src,$image->name) }}</div>
	
	@endforeach
	</div>
	
@endif
</div>