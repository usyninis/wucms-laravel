
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>



@if($unit->id)

{{ Form::model($unit, array(
	'route'		=> array('admin.units.update',$unit->id),
	'data-pubs'	=> 'notify',
	'class'		=> 'js-form forms form-unit-edit',
	'method'	=> 'PUT'
)) }}	
<div class="form-unit-edit-s1">


	
	<div class="s1-inner">
	
	
	<div class="group">
		<div class="width-80" style="float:left;position:relative;"><span style="position:absolute;right:10px;z-index:2;color: #9B9B9B;top:2px">ID: {{ $unit->id }}</span>{{ Form::text('name',null,['class'=>'width-100','style'=>'position:relative;z-index:1']) }}</div>
		
		<div class="width-20" style="float:left"><a class="btn width-100" target="_blank" href="{{ url('admin/units/'.$unit->id.'?preview=true') }}"><i class="fa fa-search"></i> Просмотр</a></div>
	</div>
	
	</div>
	
	<nav class="navbar nav-pills">
		<ul>
		<li><a class="js-tab js-ajax{{ Session::get('ui.uet')==1||!Session::get('ui.uet')? ' tab-active' : '' }}" data-action="ui/uet/1" data-content="tab-1">Основные данные</a></li>
		<li><a class="js-tab js-ajax{{ Session::get('ui.uet')==2? ' tab-active' : '' }}" data-action="ui/uet/2" data-content="tab-2">Содержание</a></li>
		<li><a class="js-tab js-ajax{{ Session::get('ui.uet')==3? ' tab-active' : '' }}" data-action="ui/uet/3" data-content="tab-3">СЕО</a></li>
		<li><a class="js-tab js-ajax{{ Session::get('ui.uet')==4? ' tab-active' : '' }}" data-action="ui/uet/4" data-content="tab-4">Свойства</a></li>
		</ul>
	</nav>
	
</div>	



<div class="form-unit-edit-inner">

	

		
		<div id="tab-1" class="nano forms-s1 js-tab-content{{ Session::get('ui.uet')==1||!Session::get('ui.uet')? '' : ' hide' }}">
		
		<div class="nano-content">	
			<div class="units-row end">
				<div class="unit-50">
					<label>{{ trans('wucms::unit.fields.code') }}: {{ Form::text('code',null,array('class' => 'width-100')) }}</label>
					<label>{{ trans('wucms::unit.fields.type') }}: {{ Form::wuSelector('type_id',Type::lists('name','id'),$unit->type_id) }}</label>
					<?php /*
					<label>type{{ Form::select('type_id', $types, $unit->type_id,array('class' => 'width-100')) }}</label>
					*/ 
  
					?>
					
					<label>{{ trans('wucms::unit.fields.template_id') }}: {{ Form::wuSelector('template_id',Template::All()->keyBy('id')->toArray(),$unit->template_id,array('class' => 'width-100')) }}</label>
					
					
					<?php /*<label>{{ trans('wucms::unit.fields.parent_id') }} {{ Form::parent_unit($unit->parent_id,$unit->id) }}</label> */ ?>
					
					<label>{{ trans('wucms::unit.fields.children_type') }} {{ Form::wuSelector('children_type_id',Type::lists('name','id'),$unit->children_type_id) }}</label>
				</div>
				<div class="unit-50">
				<div style="margin-left:2em">
				
					<ul class="blocks-2 end">						
						<li class="end"><label>Отображать {{ Form::wuCheckbox('active',1,$unit->active) }}</label></li>
						<li class="end"><label>Главная страница {{ Form::wuCheckbox('main',1,$unit->main) }}</label></li>
					</ul>
					<label>
					{{ trans('wucms::unit.fields.public_date') }}
					{{ Form::text('public_date',( ((int)$unit->public_date) ? date('d.m.Y',strtotime($unit->public_date)) : '' ),['class'=>'js-datepicker']) }}
					</label>
					Группы
					<div class="checkboxs-list">					
					@foreach(Group::all() as $group)
						<label>{{ Form::checkbox('groups[]',$group->id,in_array($group->id,$unit->groups()->lists('id'))) }} {{ $group->name }} </label>
					@endforeach
					</div>
					
					<?php 
						/* $pids = DB::table('units_childrens')->whereChildrenId($unit->id)->lists('unit_id');
						print_r($pids); */
					?>
				</div>
				</div>
			</div>
			<?php // <label>parent{{ Form::parent_unit($unit->parent_id,$unit->id) }}</label> ?>
			<h3 class="groups-title"><span>{{ trans('wucms::unit.fields.images') }}</span></h3>
			<div id="unit-images-list" class="group js-sortable-image">
						
			@foreach($unit->images as $uimage)
				@include('wucms::units.unit-image',['uimage'=>$uimage])		
			@endforeach
				<div class="a-image js-no-move"><div class="js-wu-modal btn-add" data-code="albums" data-pub="units.setImage"><i class="fa fa-plus"></i>Добавить</div></div>
			
			</div>
			
		</div>
		
		</div>
		
		<div id="tab-2" class="js-tab-content{{ Session::get('ui.uet')==2? '' : ' hide' }}">
		<div class="redactor-wrap">
		<div class="redactor-inputs">
			<label>{{ trans('wucms::unit.fields.title') }} {{ Form::text('title',null,array('class' => 'width-100')) }}</label>
			<label>{{ trans('wucms::unit.fields.short_content') }} {{ Form::textarea('short_content',null,array('rows'=>'4')) }}</label>
			
		</div>
		{{ Form::textarea('content',null,array('class'=>'js-redactor')) }}
		</div>
		
		</div>
		
		<div id="tab-3" class="nano js-tab-content{{ Session::get('ui.uet')==3? '' : ' hide' }}">
		
		<div class="nano-content">
			
			
		
		
			<label>{{ trans('wucms::unit.fields.meta_title') }} {{ Form::text('meta_title',null,array('class' => 'width-100')) }}</label>
			<label>{{ trans('wucms::unit.fields.meta_keywords') }}{{ Form::text('meta_keywords',null,array('class' => 'width-100')) }}</label>
			<label>{{ trans('wucms::unit.fields.meta_description') }}{{ Form::textarea('meta_description',null,array('rows'=>5,'class' => 'width-100')) }}</label>
		</div>
		
		</div>
		
		<div id="tab-4" class="nano js-tab-content{{ Session::get('ui.uet')==4? '' : ' hide' }}">
		
		<div class="nano-content">	
			<div class="js-prop-template hide">
			
				<div class="units-row">
					<div class="unit-33">code{{ Form::text(null,null,array('data-key'=>'code','class' => 'js-prop width-100')) }}</div>
					<div class="unit-33">value{{ Form::text(null,null,array('data-key'=>'value','class' => 'js-prop width-100')) }}</div>
					<div class="unit-33">description{{ Form::textarea(null,null,array('data-key'=>'description','rows'=>3,'class' => 'js-prop width-100')) }}</div>
				</div>
			
			</div>
			
			
			<?php 
			
				if($unit->type)
				{
					$type_props = $unit->type->props->lists('id');
				}
				else
				{
					$type_props = [];
				}
			$props = Prop::all();
			?>
			
			
			
			
			
			<div id="list-unit-props" class="list-unit-props">
			<?php /* <h3 class="groups-title"><span>Основные свойства</span></h3> */ ?>
			@foreach($props as $prop)
				
				@if( in_array($prop->id,$type_props) || $unit->prop($prop->code) )
				<div id="prop-{{ $prop->id }}">
				{{ Form::prop($prop,$unit->props) }}
				</div>
				@endif
				
				
				
				<?php /*
				{{ Form::prop($prop_type,$unit->props) }}	
				<div class="units-row">
					<div class="unit-33">code{{ Form::text('props['.$i.'][code]',$uprop->code,array('data-key'=>'code','class' => 'js-prop width-100')) }}</div>
					<div class="unit-33">value{{ Form::text('props['.$i.'][value]',$uprop->value,array('data-key'=>'value','class' => 'js-prop width-100')) }}</div>
					<div class="unit-33">description{{ Form::textarea('props['.$i.'][description]',$uprop->description,array('data-key'=>'description','rows'=>3,'class' => 'js-prop width-100')) }}</div>
				</div>
				*/?>
				
			@endforeach
			
				
			</div>
			
			

			<div class="list-unit-props list-unit-props-free">
				
					<button id="btn-prop-add" class="btn btn-orange js-show" data-show="#list-no-add-props" data-hide="#btn-prop-add" type="button"><i class="fa fa-plus"></i> Добавить свойство</button>
					
					<div id="list-no-add-props" class="hide">
					@foreach($props as $prop)
						@if( ! in_array($prop->id,$type_props) && ! $unit->prop($prop->code) )
						<div class="js-add-prop el-s1" data-id="{{ $prop->id }}">
							<div class="el-name">{{ $prop->name }}</div>
							<div class="el-desc">{{ $prop->description }}</div>
						</div>
						<div id="prop-{{ $prop->id }}" class="hide">
						{{ Form::prop($prop,$unit->props) }}
						</div>
						@endif
					@endforeach
					</div>
				
			</div>
			
			
			
			
		</div>
	
		</div>
		
	



</div>	
<div class="form-unit-edit-s2">
	{{ Form::button('<i class="fa fa-check"></i> Сохранить',array('class'	=> 'btn big btn-orange','type'=>'submit')) }}
	<button style="font-size:14px" class="btn right btn-red js-confirm-ajax" data-action="units/delete" data-pub="notify" data-id="{{ $unit->id }}" title="Удалить элемент" type="button"><i class="fa fa-trash-o"></i></button>
</div>

{{ Form::close() }}



@endif

<script type="text/javascript">
$(function(){
		$(document).on("click",".js-add-prop",function(){
			var id = $(this).data('id');
			var $prop = $("#prop-"+id);
			$prop.clone().appendTo("#list-unit-props").show().find('input').focus();
			$("#list-no-add-props #prop-"+id).remove();
			$(this).remove();
			$("#list-no-add-props").hide();
			$("#btn-prop-add").show();
			Wuapp.modal.close();
		});
	});
function addProp()
{
	var html = $(".js-prop-template").html();
	$("#props-list").append(html);
	var i = $("#props-list .units-row").length;
	$("#props-list .units-row:last .js-prop").each(function(){
		var name = 'props['+i+']['+$(this).data('key')+']';
		//console.log(name);
		$(this).prop('name',name);
		Wuapp.pub('init:nanoslider');
	});
}
/* $(function(){
	


	$( ".js-tabs" ).tabs({
		activate: function( event, ui ){
			//var active = $('.js-tabs').tabs('option', 'active');
			//$("#tabid").html('the tab id is ' + $("#tabs ul>li a").eq(active).attr("href"));
		}
	});
});
 */

$(document).on("click",".a-image .btn-delete",function(e){
	e.stopPropagation();
	$(this).parent().remove();
});

$(document).on("click",".js-remove-prop-val",function(e){
	$(this).parents(".prop-value").fadeOut(200).remove();
});


tinymce.init({
selector:".js-redactor",						// селектор
	//language_url : '/mmtools/redactor/langs/ru.js',				// путь к переводу
	language : "ru",											// в случае, если модуль лежит локально, то можно использовать вместо предыдущей строки
	skin: 'light',
	// настройки стилей, форматов
	/*style_formats: [
		{title: 'Заголовки', items: [
			{title: 'Заголовок 1', block: 'h1'},
			{title: 'Заголовок 2', block: 'h2'},
			{title: 'Заголовок 3', block: 'h3'}
		]},
		{title: 'Строчные', items: [ 
			{icon: 'bold', title: 'Полужирный', inline: 'strong'},
			{icon: 'italic', title: 'Курсив', inline: 'em'},
			{icon: 'strikethrough', title: 'Зачеркнутый', inline: 'span', styles: {textDecoration: 'line-through'}}
		]},
		{title: 'Выравнивание', items: [ 
			{icon: 'alignleft', title: 'По левому краю', block: 'p', styles: {textAlign: 'left'}},
			{icon: 'aligncenter', title: 'По центру', block: 'p', styles: {textAlign: 'center'}},
			{icon: 'alignright', title: 'По правому краю', block: 'p', styles: {textAlign: 'right'}},
			{icon: 'alignjustify', title: 'По ширине', block: 'p', styles: {textAlign: 'justify'}}
		]}
		
	],*/
	resize: false,
	// плагины
	plugins: [   // если нужны различные виды списков, то добавить плагин advlist (пока включается только админам)
				 // так же админам врубается плагин "автоссылка"
				"advlist autolink contextmenu link image lists charmap print preview hr anchor pagebreak spellchecker",
				 "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				 "save table directionality template paste textcolor"
			],

	// отключение меню, тулбар маленький и тема
	menubar : false,	
	//toolbar_items_size: 'small',
	theme : "modern",

	//body_class: "mm_redactor",
	content_css: "{{ url('packages/usyninis/wucms/admin/kube/kube.min.css') }}, {{ url('packages/usyninis/wucms/admin/css/main.css') }}",
	body_class: "redactor-body",
	relative_urls : false,
	fix_list_elements : true,  //фикс. списков к стандарту XHTML
	
	// тулбары и допустимые элементы для юзера
	toolbar1 : "styleselect,|,bold,italic,|,forecolor backcolor,|,alignleft aligncenter alignright alignjustify ,|,bullist,numlist,",
	toolbar2 : "undo,redo,|,link,unlink,|,image,wuimage,media,|,table,pastetext,charmap,|,visualblocks,code",//,preview,pagebreak		
	// ширина и высота
	//height: '100%',
	// кнопки, обработчики событий 
	setup : function(ed) {
		
		// событие "началось редактирование"
		/*ed.on('change', function() { 
			_wulib.pub('startChange');
		});
		*/
		// кнопка "Добавить изображение"
		ed.addButton('wuimage', {
			title : 'Вставить изображение из галлереи',
			icon : "wuimage",
			onclick : function() {
				Wuapp.modal.show({code:'albums',pub:'units.putImgToRedactor'});
			}
		});
	}
});
</script>

