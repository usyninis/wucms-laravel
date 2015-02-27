Wuapp.config({
	ajaxUrl: "/admin/ajax/",
	modalUrl: "/admin/ajax/modal/",
	debug: true
});

Wuapp.init();



$(document).on("change","form.js-upload-form",function( e ){
	$(this).submit().html($(this).html());
	
});
$(document).on("change","form.js-form[data-submit-onchange]",function( e ){
	$(this).submit();
	
});

$(document).on("click",".js-show",function( e ){
	$show = $($(this).data('show'));
	$hide = $($(this).data('hide'));
	
		
		if($hide.length) $hide.hide();
		if($show.length) $show.show().find("input[type=text]").focus();
		
	
});

$(document).on("click",".el-s1",function( e ){
	$(this).addClass('active').siblings(".el-s1").removeClass('active');
});
$(document).on("click",".js-confirm-ajax",function( e ){
	e.stopPropagation();
	e.preventDefault();
	if(confirm('Выполнить это действие?'))
		Wuapp.ajax($(this).data());

});

$(document).on('submit', '.js-delete-form', function(){
    return confirm('Вы уверены?');
});

$(document).on("change","#wu-modal-window form.js-form",function( e ){
	$("#wu-modal-window").data('change',true);
});


Wuapp.sub('selector:paste',function(d){
	Wuapp.modal.close();
	var $s = $(d.selector);
	if($s.length)
	{	
		$s.data('id',d.id)
			.find('input').val(d.id).change().end()
			.find('.sel-item').html(d.name);
	}
});
Wuapp.sub("settings/delete",function(d){
	Wuapp.pub("notify",d);
	if(d.status=='ok') window.location.reload();
});
Wuapp.sub("cloneProp",function(d){
	var prop_id = d.id;
	var $prop = $("#prop-"+prop_id);
	var prop_html = $prop.find(".prop-value-template").html();
	$prop.find(".prop-values").append(prop_html);
	//alert(prop_html);
});


$(document).on("submit","form.js-form",function( e ){
	e.preventDefault();	
	var $form = $(this), a, url;
	var alc = Wuapp.props.ajaxLoadClass;
	var aak = Wuapp.props.ajaxActionKey;
	if($form.data(alc)) return false;		
	$form.data(alc,true).addClass(alc);		
	if(a = $form.data('action')) url = Wuapp.props.ajaxUrl+a ;
	else url = $form.prop('action');
	var p = $form.data('pub');
	var ps = $form.data('pubs');
	$form.ajaxSubmit({
		url: url,
		//dataType:"json",
		dataType:"json",
		error: function(){
			$form.data(alc,false).removeClass(alc);
		},
		success: function(d){
			$form.data(alc,false).removeClass(alc);
			if(a) Wuapp.pub(a,d);
			if(p) Wuapp.pub(p,d);
			if(ps) Wuapp.pubs(ps,d);
				
			
							
		}
	});
	
});

$(document).on('click','.js-tab',function(){

	$(".js-tab.tab-active").removeClass('tab-active');
	$(this).addClass('tab-active');
	var c = $(this).data('content');
	$(".js-tab-content").hide();
	var $tabc = $("#"+c);
	$tabc.show();
	Wuapp.pub('init:nanoslider');
	//if($tabc.hasClass('nano')) $tabc.nanoScroller();	

});


Wuapp.sub("document:ready init:nanoslider",function(d){
	$(".nano").nanoScroller();
	
});


Wuapp.sub('reload',function(d){ 
	
	if(d.status=='ok')
	$.get("",false,function(data){
		
		$(".js-ajax-section").each(function(){
			var id = $(this).prop('id');
			if( ! id) 
			{
				console.error('not set id attribute');
				return false;
			}
			
			$("#"+id).html($(data).find('#'+id).html());
		});
		
	});
	
	
	//$("#ajax").html($(data).find('#ajax'));
	//$("#"+sid).load(" #"+sid+" > *");
});



Wuapp.sub('changeListFilter',function(d){ 
	Wuapp.pub('reload','sfdfs');	
});

Wuapp.sub("document:ready",function(d){

	if($( ".js-sortable-props" ).length)
	$( ".js-sortable-props" ).sortable({
		handle: ".js-handle",
		placeholder: "prop-value fake",
		//items: ".a-image:not(.js-no-move)",
	});
		
	
	
	
	
	
	if($( ".js-sortable-image" ).length)
	$( ".js-sortable-image" ).sortable({
		//handle:".fa",
		placeholder: "a-image fake",
		items: ".a-image:not(.js-no-move)",
		/*
		
		connectWith: ".js-sortable",
		update: function(event, ui){
			ui.item.parent("form").submit();
		} */
	});

	$('.js-datepicker').Zebra_DatePicker({
		//direction: 1,
		format: 'd.m.Y',
		months: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
		days: ["Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье"],
		days_abbr: ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"],
		first_day_of_week: 0,
		offset: [-158, 110],
		weekend_days: [5,6],
		show_icon: false,
        show_select_today: false,
		show_clear_date: false
		
	});
	

	
});


// wu-selector 	
$(document).on('click','.wu-selector:not(.disabled)',function(){
	$(".wu-selector.checked").not(this).removeClass('checked');
	$(this).toggleClass('checked');
});
$(document).on('click','.wu-selector .sel-section .item',function(){
	$(this).siblings().removeClass('active');
	$(this).addClass('active').parent().parent().find('.sel-item').html($(this).find('.item-name').html())
		.end().find('input').val($(this).data('value')).change();
});
$(document).on('click',function(e){	
	if ($(e.target).closest(".wu-selector").length) return; 
	$(".wu-selector.checked").removeClass('checked');
	e.stopPropagation();
});

$(document).on('click','#wu-modal-window',function(e){
	if ($(e.target).closest(".wu-selector").length) return; 
	$(".wu-selector.checked").removeClass('checked');
	e.stopPropagation();
});

//	end wu-selector
//	wu-checkbox
$(document).on('change','.wu-checkbox input',function(){
	$(this).parents('.wu-checkbox').toggleClass('checked');
});
//	end wu-checkbox
	
Wuapp.sub("images.delete",function(d){
	
	if(d.status=='ok') $("#a-image-"+d.id).fadeOut(200);
	
});

Wuapp.sub("images.add",function(d){
	//alert(d);
	if(d.images)
	{
		var i, l = d.images.length;
		for (i=0;i<l;++i)
		{
			
			var ihtml = d.images[i];
			//alert(ihtml);
			$("#a-images-list").append(ihtml);
		}
		$("#a-images-list").find(".a-image.hide").fadeIn(200);
	}
	Wuapp.pub('notify',d);
});

Wuapp.sub('unit:setImage',function(img){



	
	//console.log(img);
	if(img.changeId) $img = $("#a-image-"+img.changeId);
	else 
	{
		
		$("#unit-images-list .a-image:last").before('<div id="a-image-'+img.id+'" class="a-image"><div class="delete" title="Удалить изображение"><i class="fa fa-close"></i></div><div class="js-wu-modal" data-code="albums" data-pub="unit:setImage" data-id="'+img.id+'"><img src="" /><input type="hidden" name="images[]" value="'+img.id+'" /></div></div>');
		$img = $("#a-image-"+img.id);
		$img.data(img);
	}
	$img.find("img").prop('src',img.thumb);
	$img.find("input").val(img.id);
	Wuapp.modal.close();
	/* $("input[name=image_id]").val(img.id);
	$(".unit-image img").prop('src',img.src); */
});
Wuapp.sub("notifyModal",function(d){
	if(d.status=='ok')
	{
		$("#wu-modal-window").data("change",false);
		Wuapp.modal.close();		
	}
	Wuapp.pub("notify",d);
	
});
Wuapp.sub("notify",function(d){
	var id = 'notify-'+Date.now();
	var c = 'tools-message';
	if(d.status=='ok') c = c + ' tools-message-green';
	else c = c + ' tools-message-red';
	$("body").append('<div id="'+id+'" class="'+c+'">'+d.message+'</div>');
	if(d.message) $("#"+id).message();
	if(d.status=='ok' && d.reload) window.location.href=d.reload;
});