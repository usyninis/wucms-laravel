<div id="a-image-{{ $image->id }}" class="a-image {{ (empty($hide)?'':'hide') }}" data-id="{{ $image->id }}">
	<div class=" js-wu-modal" data-code="image" data-id="{{ $image->id }}">
	{{ HTML::image($image->thumb(200),$image->name) }}
	</div>
	
	{{ Form::delete('admin/images/'.$image->id,'<i class="fa fa-close"></i>',['data-pubs'=>'images.delete notify'],['class'=>'btn-delete']) }}
</div>