
@if($image = Image::find(Input::get('id')))

	<meta name="wu-modal-title" content="Редактирование изображения">
	
	{{ Form::model($image,array(
		'route' => array('admin.images.update',$image->id),		
		
		'class'		=> 'js-form forms end',
		'data-pubs'	=> 'notifyModal',
		'method'	=> 'PUT'
	)) }}
			<label>
			{{ trans('wucms::image.fields.src') }}
			{{ Form::text('src',$image->src,[
				'class'		=>'width-100 disabled',
				'disabled'	=>'disabled',				
				'style'=>'background:#e7e7e7;font-size:0.9em'
			]) }}
		</label>

	<div class="units-row end">
		
		<div class="unit-50">
			<label>
			{{ trans('wucms::image.fields.name') }}
			{{ Form::text('name',null,['class'=>'width-100']) }}
			</label>
			<label>
			{{ trans('wucms::image.fields.album_id') }}
			{{ Form::wuSelector('album_id',Album::all()->lists('name','id'),$image->album_id,['class'=>'width-100']) }}
			</label>
			<label>
			{{ trans('wucms::image.fields.description') }}
			{{ Form::textarea('description',null,['class'=>'width-100','rows'=>4]) }}
			</label>
			
			{{ Form::button('Сохранить',['class'=>'btn btn-orange','type'=>'submit']) }}
			{{ Form::button('Отмена',['class'=>'btn js-wu-modal-close']) }}
			
			
		</div>	
		
		<div class="unit-50">
			{{ HTML::image($image->thumb(400),$image->name,['style'=>'max-width:100%;max-height:300px']) }}
			

			
		</div>
	</div>
	{{ Form::close() }}
@endif
</div>