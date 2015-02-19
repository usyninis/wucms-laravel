<div id="a-image-{{ $image->id }}" class="a-image {{ (empty($hide)?'':'hide') }}" data-id="{{ $image->id }}">
	<div class=" js-wu-modal" data-code="image" data-id="{{ $image->id }}">
	{{ HTML::image($image->src,$image->name) }}
	</div>
	<div class="delete js-ajax" data-id="{{ $image->id }}" data-_token="{{ csrf_token() }}" data-action="images/delete" title="Удалить изображение"><i class="fa fa-close"></i></div>
	
</div>