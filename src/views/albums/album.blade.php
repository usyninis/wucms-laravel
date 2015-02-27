<style>
.album-wrap{padding:1em}
.album-list-images{padding:1em;}
</style>

<div class="album-wrap">
<div class="header-s2">
@if(!empty($album))

	
	<h2 class="h-title">{{ $album->name }}<button class="btn btn-gray smaller right js-show" data-show="#album-form" data-hide="#album-header">Редактировать</button></h3>
	
	


@else
	<h2 class="h-title">Все фотографии</h3>
@endif
</div>

<div id="a-images-list" class="js-sortable-image album-list-images">
	<div class="a-image js-no-move">
		<div class="file-upload-form-fake"><div class="f-text">Загрузить фото</div></div>
		{{ Form::open(array(
			'route'		=> 'admin.images.store',
			'files'		=> true,
			'class'		=> 'js-form forms js-upload-form file-upload-form',
			'data-pubs'	=> 'images/add',
			
			))
		}}
		{{ Form::hidden('album_id',object_get($album,'id')) }}

			{{ Form::file('images[]',['class'=>'file-upload-input','accept'=>'image/jpeg','min'=>1,'max'=>50,'multiple'=>true]) }}
			
			

		{{ Form::close() }}
	</div>


	

@forelse($images as $image)
	@include('wucms::albums.image',['image'=>$image])
@empty
	нет фото
@endforelse
</div>
<div style="clear:both">
<?php echo $images->links(); ?>
</div>
</div>






