(function($) {
	jQuery.fn.extend({ curReturn: null, jQueryInit: jQuery.fn.init });
  
	jQuery.fn.extend({
	  init: function( selector, context ) {
		jQuery.fn.curReturn = new jQuery.fn.jQueryInit(selector, context);
		return jQuery.fn.curReturn;
	  }
	});
  
	jQuery.extend({
	  namespaceData: {},
	  namespaceExtend: function(NameSpaces){
		if(eval(NameSpaces) != undefined){ $.extend(eval(NameSpaces), {}); }else{ eval(NameSpaces + " = {};"); }
	  },
	  namespace: function(namespaces, objects, inherited){
		if(typeof objects == "function"){
		  if(namespaces.match(".")){
			nss = namespaces.split(".");
			snss = "";
			for(var i = 0; i < nss.length; i++){
			  snss += "['" + nss[i] + "']";
  
			  jQuery.namespaceExtend("jQuery.namespaceData" + snss);
			  jQuery.namespaceExtend("jQuery.fn" + snss);
			}
			eval("jQuery.namespaceData" + snss + " = objects;");
  
			eval("jQuery.fn" + snss + " = " +
			  "function(){ return eval(\"jQuery.namespaceData" + snss + 
				((inherited)? ".apply" : "") + "(jQuery.fn.curReturn, arguments)\"); }");
  
		  }else{
			jQuery.extend({
			  namespaces: function(){
				return objects(jQuery.fn.curReturn);
			  }
			});
		  }
		}else{
		  if(arguments.length < 3) inherited = objects['inherited'] == true;        
		  for(var space in objects){
			jQuery.namespace(namespaces + "." + space, objects[space], inherited);
		  };
		}
	  }
	});
  
   $.namespace("fun", {
		invites: function(elems, options){
			return invites(elems[0], options);
		}
	});
	
   $.namespace("fun.iframe", {
		setHeight: function(elems, options){
			return setHeight(options[0]);
		},
		setAutoResize: function(elems){
			var height = document.body.offsetHeight + 20;
			return setHeight(height);
		}
	});

	function setHeight(height) {
		var funProxy = "http://fun.wayi.com.tw/proxy.html";
		if(!$("#funProxy").length){
		  $('<iframe id="funProxy" style="display:none;"><\/iframe>').appendTo('body');
		}
		$("#funProxy").attr("src",funProxy + '?t='+ new Date().getTime()+'#method=setIframeSize&height=' + height);
	};
  
	function invites(elems,options) {
			if(options.token_key == 'undefined' || options.token_screet == 'undefined') return;
			var defaults = {max:15};
			var settings = $.extend(defaults, options[0]);
			settings = $.param(settings).toLowerCase();
			var iframe = $('<iframe id="funInvite" style="width:720px; height:560px;"  scrolling="no" frameborder="0" src="http://api.fun.wayi.com.tw/invites?' + settings + '"><\/iframe>');
			$(elems).append(iframe);
	};
})(jQuery);