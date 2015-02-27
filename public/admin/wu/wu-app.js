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
		//console.log(o);			
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
			$d.hide().removeClass('w-open').width(w).html('').data('code',o.code);			
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
						var t = $('meta[name=wu-modal-title]').prop("content");
						if(w = $('meta[name=wu-modal-width]').prop("content")) $d.width(w);
						if(t)	$d.prepend('<div class="wu-modal-window-title">'+t+'</div>');
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

