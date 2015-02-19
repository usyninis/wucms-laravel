
	
// Super-basic example:
/* $.ajaxSetup({
  url: "/ajax/",
  //global: false,
  dataType: "json"
}); */

/* var au	= "/mmtools/ajax/",
	al	= {},
	debug = true;

var	aa	= "action",
	pa	= "pub",
	pd	= "pub-data";

var	afc = "js__form",
	aec = "js__ajax",
	apc	= "js__pub",
	alc = "load";
 */
(function(__global){
    if (!__global.console || (__global.console && !__global.console.log)) {
         __global.console = {
         log: (__global.opera && __global.opera.postError)
             ? __global.opera.postError
         : function(){ }
        }
    }
})(this);
 
var Wuapp = {
 
    // «десь объ¤вл¤ютс¤ частные переменные и функции	

	version: "2.2 15012015",
	info: function() {  
		console.log('wulib: [version='+this.version+'] [ajaxUrl='+this.props.ajaxUrl+']');
	},	
	init: function() {
		$(function(){
			Wuapp.pub('document:ready');
		});
		$(document).on("click",".js-ajax",function(e){
			e.preventDefault();
			$(this).data('href',$(this).prop('href'));			
			Wuapp.ajax($(this).data());
		});
		$(document).on("click",".js-pub",function(e){
			e.preventDefault();
			Wuapp.pub($(this).data('pub'),$(this).data());
		});
		this.modal.init();
		return this;
	},
	props: {		
		ajaxUrl: "/ajax/",		
		ajaxActionKey: "action",
		modalUrl: "/ajax/modal/",
		//modalCodeKey: "code",
		//ajaxFormClass: "js__form",
		ajaxLoadClass: "load",	
		debug: false
	},
	subscribers: {
		//
	},
	ajax: function(o){		
		var _ = this,
			pubs = '';				
		if( ! o.action && ! o.href) return false;
		if(o.action)
		{
			var a = o.action;
			pubs = a;
			var url = _.props.ajaxUrl+a;
		}
		else
		{	
			pubs = o.href;
			var url = o.href;			
		}
		
		if(o.pub) 
		{
			pubs = pubs + ' ' + o.pub;		
			delete o['pub'];
		}
		if(o.pubs) 
		{
			pubs = pubs + ' ' + o.pubs;		
			delete o['pubs'];
		}
		
	
		
		delete o['action']; 
		delete o['href']; 
		
		var type = o.method || 'get' ;
		$.ajax({
			type: type,
			data: o,
			url: url,
			error: function(data){	
				if(Wuapp.props.debug) console.error('wulib: error '+n);
				return false;
			},
			success: function(data){
				if(pubs) Wuapp.pubs(pubs,data);			
				
			} 
		});
	},
	pubs: function(n,d)
	{
		if(n) 
		{
			var pn = n.split(' '), i, l = pn.length;
			for (i=0;i<l;++i) this.pub(pn[i],d);//(pn[i],d);
			
		}	
	},
	pub: function(n,d){
		var _ = this;
		if(_.props.debug) console.log('wulib: pub '+n);			
		if(n in _.subscribers){
			var a = _.subscribers[n];
			var l = a.length;
			for (var i = 0, length = l; i < length; i++) {
				if (i in a) a[i](d);
			}
		}
		return this;		
	},
	sub: function(pn,f){
		var _ = this;
		var an = pn.split(' ');
		var i; var l = an.length;
		for (i=0;i<l;++i)
		{
			var n = an[i];
			if(_.props.debug) console.log('wulib: subscriber add from "'+n+'"');
			var a = new Array();
			if(n in _.subscribers) a = _.subscribers[n];
			a.push(f);
			_.subscribers[n] = a;
		}
		return this;
	},
    config: function(newProps) {
		if (typeof newProps == 'object')
			for (var a in newProps) 
				this.props[a] = newProps[a];	
		return this;
    },
	
	modal: {
		template: "<div id=\"wu-modal-overlay\" class=\"wu-modal-overlay js-wu-modal-close\"><div class=\"wu-modal-indicator\">Пожалуйста, подождите..</div><div id=\"wu-modal-window\" class=\"wu-modal-window\"></div></div>",
		init: function(){
			window.onresize = function() { Wuapp.modal.resize(); }
			

			$(document).on('click','#wu-modal-window',function(e){e.stopPropagation();});
			$(document).on('click','.js-wu-modal-close',function(e){e.preventDefault();Wuapp.modal.close();});
			$(document).on('click','.js-wu-modal',function(e){e.preventDefault();e.stopPropagation();Wuapp.modal.show($(this).data())});
		},
		show: function(o){
			var _ = this;
			if(!o.code&&!o.selector) 
			{
				if(Wuapp.props.debug) console.error('wulib: not set modal code');
				return false;
			}
			if(!$("body").data("mw")){
				$("body").prepend(_.template).data("mw",true);
				_.show(o);
				return false;
			}
			
			var $o = $("#wu-modal-overlay"); 
			var $d = $("#wu-modal-window");
			
			var w = o.width || 'auto';
			$d.removeClass('w-open').width(w).html('').data('code',o.code);			
			$o.addClass(Wuapp.props.ajaxLoadClass).addClass('w-open').show();	
			$d.show();	
			$("body").addClass('w-open');
			if(o.code)
			{
				var url = o.url || (Wuapp.props.modalUrl+o.code); 			
				$.ajax({
					type: 'get',
					data: o,
					url: url,
					error: function(data){
						if(Wuapp.props.debug) console.error('wulib: error '+n);
						return false;
					},
					success: function(data){			
						Wuapp.pub('modal:show:'+o.code,o);
						$o.removeClass(Wuapp.props.ajaxLoadClass);
										
						$d.html('<div class="wu-modal-window-content">'+data+'</div>').
							prepend('<div class="wu-modal-window-close js-wu-modal-close" title="Закрыть окно"><i class="fa fa-close"></i></div>');
						if(o.title)	$d.prepend('<div class="wu-modal-window-title">'+o.title+'</div>');
						//$o;
						$d.addClass('w-open');
						
						Wuapp.modal.resize();
						
					} 
				});
			}
			else
			{
				$s = $(o.selector);
				if(!$s.length) 
				{
					if(Wuapp.props.debug) console.error('wulib: not find modal selector');
					return false;
				}					
					$o.removeClass(Wuapp.props.ajaxLoadClass);
					var html = $s.html();
					$s.html('');
					$d.html('<div class="wu-modal-window-content">'+html+'</div>').
						prepend('<div class="wu-modal-window-close js-wu-modal-close" title="Закрыть окно"><i class="fa fa-close"></i></div>');
					if(o.title)	$d.prepend('<div class="wu-modal-window-title">'+o.title+'</div>');
					//$o;
					$d.data('selector',o.selector).addClass('w-open');
					
					Wuapp.modal.resize();
				
			}
		},
		resize: function(){
			var $mw = $("#wu-modal-window");
			var wh = $(window).height();
			var mwh = $mw.height();
			if(mwh<wh) $mw.css('top',(wh-mwh-100)/2); else $mw.css('top',0);
		},
		close: function(){
			var $mo = $("#wu-modal-overlay"); 
			var $mw = $("#wu-modal-window");
			if($mw.data('change')) if(!confirm('Вы действительно хотите закрыть окно? Введенные данные будут утеряны.')) return false; 
			Wuapp.pub('modal:close:'+$mw.data('code'));
			
			if($("#wu-modal-overlay").is(":visible"))
			{
				if($mw.data('selector'))
				{
					var $s = $($mw.data('selector'));
					var html = $mw.find('.wu-modal-window-content').html();
					$s.html(html);					
				}
				$mo.removeClass('w-open').hide();
				$mw.data('change',false).removeClass('w-open').hide().html('');
				$("body").removeClass('w-open');
			}	
		}
	}
};


/* (function( $ ) {

	

	$.fn.wuModal = function( options ) {

		var template = "<div id=\"wu-modal-overlay\" class=\"wu-modal-overlay js-wu-modal-close\"><div id=\"wu-modal-window\" class=\"wu-modal-window\"></div></div>";
	
		var settings = $.extend( {
			//'template'         : 'top',
			'background-color' : 'blue'
		}, options);
		
		

	};
	
	$.fn.wuModal = function( method ) {
    
		// логика вызова метода
		if ( methods[method] ) {
		  return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
		  return methods.init.apply( this, arguments );
		} else {
		  $.error( 'Метод с именем ' +  method + ' не существует для jQuery.tooltip' );
		} 
	};
  
})(jQuery); */
	
/* $(document).on("click","."+aec,function(e){
	e.preventDefault();
	var a = $(this).data('action');
	var d = $(this).data('send-data');
	var m = $(this).data('send-method');		
	//var url = _.ajax_url+_.ajax_prfx+_.ajax_key+'='+a;
	
	if(al[a]) 
	{
		if(debug) console.log('wulib: ajax-'+a+' on process');	
		return false;
	}
	if(debug) console.time('wulib: ajax-'+a);
	al[a] = true;
	var type = 'get'; if(m=='post') type = m;	
	//if(!t) t = "json";
	$.ajax({
		type: type,
		data: d,
		url: au,
		//dataType:"json",
		complete: function(){			
			al[a] = false;
		},
		error: function(data){
			if(debug) console.error('wulib: error ajax "'+a+'"');
			$.pub(a,data);
		},
		success: function(data, textStatus){			
			if(debug) console.timeEnd('wulib: ajax-'+a+' textStatus:'+textStatus);	
			$.pub(a,data);
		} 
	});
});

$(document).on("click","."+apc,function( e ){
	e.preventDefault();
	$.pub($(this).data('pub'), $(this).data(pd));
}); */



