<?php
	
	if( ! $album_id = Input::get('album_id'))
	{
		
		if($album = Album::first()) 
		$album_id = $album->id; else $album_id = 0;
	}
	else
	{
		$album = Album::find($album_id);
	}
	
	
	
?>

<meta name="wu-modal-title" content="Добавить изображение">
<div class="s-modal-images">
<div class="units-row end">

<div class="unit-20">
<nav class="nav nav-stacked">
    <ul>
@foreach(Album::all() as $calbum)
	@if($album_id == $calbum->id)        
        <li><span>{{ $calbum->name }}</span></li>
    @else
		<li><a href="#" class="js-wu-modal" data-code="albums" data-id="{{ Input::get('id') }}" data-album_id="{{ $calbum->id }}" data-pub="{{ Input::get('pub') }}">{{ $calbum->name }}</a></li>
	@endif
@endforeach
</ul>
</nav>
</div>
<div class="unit-80">
@if($images = Image::whereAlbumId($album_id)->orderBy('id','DESC')->get())

	
	
	<div id="a-images-list" class="group">
	
		
	
		<div class="a-image a-image-upload">
			<div class="file-upload-form-fake">
				<span class="fupf-icon">
					<i class="fa fa-upload"></i>
					<i class="fa fa-spinner fa-spin"></i>
				</span>
				<span class="fupf-text">Загрузить фото</span>
			</div>
			{{ Form::open(array(
				'route'		=> 'admin.images.store',
				'files'		=> true,
				'class'		=> 'js-form forms js-upload-form file-upload-form',
				'data-pubs'	=> 'images.addModal notify',
				
				))
			}}
				{{ Form::hidden('album_id',object_get($album,'id')) }}
				
				{{ Form::file('images[]',['class'=>'file-upload-input','accept'=>'image/jpeg','min'=>1,'max'=>50,'multiple'=>true]) }}
				
				

			{{ Form::close() }}
		</div>
			
		
		<?php 
			foreach($images as $key => $image)
			{ 
				if($key>42)
				{
					echo '<button class="btn small js-pub" id="showMoreImages" data-pub="showMoreImages" type="button">Показать все ('.count($images).')</button>';
					break;
				}
			?>
			<div class="a-image js-pub" data-change-id="{{ Input::get('id') }}" data-pub="{{ Input::get('pub') }}" data-id="{{ $image->id }}" data-src="{{ $image->src }}" data-thumb="{{ $image->thumb(200) }}">{{ HTML::image($image->thumb(200),$image->name) }}</div>
			<?php
			}
			echo '<div id="showMoreImagesList" class="hide">';
			foreach($images as $key => $image)
			{ 
				if($key>42)
				{
					?>
					<div class="a-image js-pub" data-change-id="{{ Input::get('id') }}" data-pub="{{ Input::get('pub') }}" data-id="{{ $image->id }}" data-src="{{ $image->src }}" data-thumb="{{ $image->thumb(200) }}"></div>
					<?php

				}
			}
			echo '</div>';
		?>
	</div>
	
@endif
</div>
</div>
</div>
