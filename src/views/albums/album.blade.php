<style>
.album-wrap{padding:1em}
.album-list-images{padding:1em;}
</style>

<div class="album-wrap">
<div class="header-s2 group">
@if(!empty($album))

	
	<h2 class="h-title" style="float:left">
		{{ $album->name }}
	</h2>
	<div class="right">
		{{ Form::delete('admin/albums/'.$album->id,'<i class="fa fa-trash-o"></i>',['class'=>'js-form left','data-pubs'=>'albums.delete notify'],['class'=>'btn smaller btn-red']) }}
		<button class="btn btn-gray smaller js-wu-modal" data-code="album" data-id="{{ $album->id }}"><i class="fa fa-pencil"></i></button>
		
	</div>
	
	


@else
	<h2 class="h-title">Все фотографии</h3>
@endif
</div>

<div id="a-images-list" class="{{ (object_get($album,'id')?'js-sortable-image':'') }} lbum-list-images">
	
	<div class="a-image a-image-upload js-no-move">
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
			'data-pubs'	=> 'images.add',
			
			))
		}}
			{{ Form::hidden('album_id',object_get($album,'id')) }}
			
			{{ Form::file('images[]',['class'=>'file-upload-input','accept'=>'image/jpeg','min'=>1,'max'=>50,'multiple'=>true]) }}
			
			

		{{ Form::close() }}
	</div>


	

@forelse($images as $image)

	@include('wucms::albums.image',['image'=>$image])
	
@empty
	
	
	
@endforelse
</div>

<div style="clear:both">
<?php echo $images->links(); ?>
</div>

</div>






