<div id="a-image-{{ $uimage->id }}" class="a-image">
	<div class="btn-delete" title="Удалить изображение">
		<i class="fa fa-close"></i>
	</div>
	<div class="js-wu-modal" data-code="albums" data-pub="units.setImage" data-album_id="{{ $uimage->album_id }}" data-id="{{ $uimage->id }}">
		{{ HTML::image($uimage->thumb(200)) }}{{ Form::hidden('images[]',$uimage->id) }}
	</div>
</div>