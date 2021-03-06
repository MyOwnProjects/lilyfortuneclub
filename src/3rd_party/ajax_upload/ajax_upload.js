/*
 * Copyright 2015, Michael Brook, All rights reserved.
 * http://simpleupload.michaelcbrook.com/
 *
 * simpleUpload.js is an extremely simple yet powerful jQuery file upload plugin.
 * It is free to use under the MIT License (http://opensource.org/licenses/MIT)
 *
 * https://github.com/michaelcbrook/simpleUpload.js
 * @michaelcbrook
 */
function simpleUpload(e,l,n){function t(){if("object"==typeof n&&null!==n){if("boolean"==typeof n.forceIframe&&(U=n.forceIframe),"function"==typeof n.init&&(I=n.init),"function"==typeof n.start&&(L=n.start),"function"==typeof n.progress&&(q=n.progress),"function"==typeof n.success&&(W=n.success),"function"==typeof n.error&&(_=n.error),"function"==typeof n.cancel&&(M=n.cancel),"function"==typeof n.complete&&(D=n.complete),"function"==typeof n.finish&&(N=n.finish),"string"==typeof n.hashWorker&&""!=n.hashWorker&&(S=n.hashWorker),"function"==typeof n.hashComplete&&(z=n.hashComplete),"object"==typeof n.data&&null!==n.data)for(var e in n.data)F[e]=n.data[e];if("number"==typeof n.limit&&y(n.limit)&&n.limit>0&&(w=n.limit),"number"==typeof n.maxFileSize&&y(n.maxFileSize)&&n.maxFileSize>0&&(x=n.maxFileSize),"object"==typeof n.allowedExts&&null!==n.allowedExts)for(var e in n.allowedExts)j.push(n.allowedExts[e]);if("object"==typeof n.allowedTypes&&null!==n.allowedTypes)for(var e in n.allowedTypes)k.push(n.allowedTypes[e]);if("string"==typeof n.expect&&""!=n.expect){var t=n.expect.toLowerCase(),o=["auto","json","xml","html","script","text"];for(var e in o)if(o[e]==t){E=t;break}}if("object"==typeof n.xhrFields&&null!==n.xhrFields)for(var e in n.xhrFields)T[e]=n.xhrFields[e]}if("object"==typeof l&&null!==l&&l instanceof jQuery){if(!(l.length>0))return!1;l=l.get(0)}if(!U&&window.File&&window.FileReader&&window.FileList&&window.Blob&&("object"==typeof n&&null!==n&&"object"==typeof n.files&&null!==n.files?b=n.files:"object"==typeof l&&null!==l&&"object"==typeof l.files&&null!==l.files&&(b=l.files)),("object"!=typeof l||null===l)&&null==b)return!1;"object"==typeof n&&null!==n&&"string"==typeof n.name&&""!=n.name?C=n.name.replace(/\[\s*\]/g,"[0]"):"object"==typeof l&&null!==l&&"string"==typeof l.name&&""!=l.name&&(C=l.name.replace(/\[\s*\]/g,"[0]"));var r=0;if(null!=b?b.length>0&&(r=b.length>1&&window.FormData&&$.ajaxSettings.xhr().upload?w>0&&b.length>w?w:b.length:1):""!=l.value&&(r=1),r>0){if("object"==typeof l&&null!==l){var i=$(l);J=$("<form>").hide().attr("enctype","multipart/form-data").attr("method","post").appendTo("body"),i.after(i.clone(!0).val("")).removeAttr("onchange").off().removeAttr("id").attr("name",C).appendTo(J)}for(var s=0;r>s;s++)!function(e){R[e]={state:0,hashWorker:null,xhr:null,iframe:null},A[e]={upload:{index:e,state:"init",file:null!=b?b[e]:{name:l.value.split(/(\\|\/)/g).pop()},cancel:function(){if(0==u(e))d(e,4);else{if(1!=u(e))return!1;d(e,4),null!=R[e].hashWorker&&(R[e].hashWorker.terminate(),R[e].hashWorker=null),null!=R[e].xhr&&(R[e].xhr.abort(),R[e].xhr=null),null!=R[e].iframe&&($("iframe[name=simpleUpload_iframe_"+R[e].iframe+"]").attr("src","javascript:false;"),simpleUpload.dequeueIframe(R[e].iframe),R[e].iframe=null),P(e)}return!0}}}}(s);var p=H(r);if(p!==!1){var f=r;if("number"==typeof p&&y(p)&&p>=0&&r>p){f=p;for(var m=f;r>m;m++)d(m,4)}for(var c=[],v=0;f>v;v++)X(v,A[v].upload.file)!==!1&&(c[c.length]=v);c.length>0?(B=c.length,simpleUpload.queueUpload(c,function(e){a(e)}),simpleUpload.uploadNext()):Z()}else{for(var m in A)d(m,4);Z()}}}function a(e){if(1==u(e)){var n=null;if(null!=b){if(void 0==b[e]||null==b[e])return void K(e,{name:"InternalError",message:"There was an error uploading the file"});n=b[e]}else if(""==l.value)return void K(e,{name:"InternalError",message:"There was an error uploading the file"});return j.length>0&&!c(j,n)?void K(e,{name:"InvalidFileExtensionError",message:"That file format is not allowed"}):k.length>0&&!v(k,n)?void K(e,{name:"InvalidFileTypeError",message:"That file format is not allowed"}):x>0&&!h(x,n)?void K(e,{name:"MaxFileSizeError",message:"That file is too big"}):void(null!=S&&null!=z?o(e):i(e))}}function o(e){if(null!=b&&void 0!=b[e]&&null!=b[e]&&window.Worker){var l=b[e];if(void 0!=l.size&&null!=l.size&&""!=l.size&&y(l.size)&&(l.slice||l.webkitSlice||l.mozSlice))try{var n=new Worker(S);n.addEventListener("error",function(){n.terminate(),R[e].hashWorker=null,i(e)},!1),n.addEventListener("message",function(l){if(l.data.result){var t=l.data.result;n.terminate(),R[e].hashWorker=null,r(e,t)}},!1);var t,a,o,s,p,f;return f=function(e){n.postMessage({message:e.target.result,block:a})},p=function(){a.end!==l.size&&(a.start+=t,a.end+=t,a.end>l.size&&(a.end=l.size),o=new FileReader,o.onload=f,l.slice?s=l.slice(a.start,a.end):l.webkitSlice?s=l.webkitSlice(a.start,a.end):l.mozSlice&&(s=l.mozSlice(a.start,a.end)),o.readAsArrayBuffer(s))},t=1048576,a={file_size:l.size,start:0},a.end=t>l.size?l.size:t,n.addEventListener("message",p,!1),o=new FileReader,o.onload=f,l.slice?s=l.slice(a.start,a.end):l.webkitSlice?s=l.webkitSlice(a.start,a.end):l.mozSlice&&(s=l.mozSlice(a.start,a.end)),o.readAsArrayBuffer(s),void(R[e].hashWorker=n)}catch(u){}}i(e)}function r(e,l){if(1==u(e)){var n=!1,t=function(l){return 1!=u(e)?!1:n?!1:(n=!0,Y(e,100),G(e,l),!0)},a=function(){return 1!=u(e)?!1:n?!1:(n=!0,i(e),!0)},o=function(l){return 1!=u(e)?!1:n?!1:(n=!0,K(e,{name:"HashError",message:l}),!0)};z.call(A[e],l,{success:t,proceed:a,error:o})}}function i(n){if(1==u(n)){if(null!=b){if(void 0==b[n]||null==b[n])return void K(n,{name:"InternalError",message:"There was an error uploading the file"});if(window.FormData){var t=$.ajaxSettings.xhr();if(t.upload){var a=b[n],o=new FormData;f(o,F),o.append(C,a);var r={url:e,data:o,type:"post",cache:!1,xhrFields:T,beforeSend:function(e){R[n].xhr=e},xhr:function(){return t.upload.addEventListener("progress",function(e){e.lengthComputable&&Y(n,e.loaded/e.total*100)},!1),t},error:function(){R[n].xhr=null,K(n,{name:"RequestError",message:"Could not get response from server"})},success:function(e){R[n].xhr=null,Y(n,100),G(n,e)},contentType:!1,processData:!1};return"auto"!=E&&(r.dataType=E),void $.ajax(r)}}}"object"==typeof l&&null!==l?s(n):K(n,{name:"UnsupportedError",message:"Your browser does not support this upload method"})}}function s(l){if(0==l){var n=simpleUpload.queueIframe({origin:g(e),expect:E,complete:function(e){1==u(l)&&(R[l].iframe=null,simpleUpload.dequeueIframe(n),Y(l,100),G(l,e))},error:function(e){1==u(l)&&(R[l].iframe=null,simpleUpload.dequeueIframe(n),K(l,{name:"RequestError",message:e}))}});R[l].iframe=n;var t=p(F);J.attr("action",e+(-1==e.lastIndexOf("?")?"?":"&")+"_iframeUpload="+n+"&_="+(new Date).getTime()).attr("target","simpleUpload_iframe_"+n).prepend(t).submit()}else K(l,{name:"UnsupportedError",message:"Multiple file uploads not supported"})}function p(e,l){(void 0===l||null===l||""===l)&&(l=null);var n="";for(var t in e)void 0===e[t]||null===e[t]?n+=$("<div>").append($('<input type="hidden">').attr("name",null==l?t+"":l+"["+t+"]").val("")).html():"object"==typeof e[t]?n+=p(e[t],null==l?t+"":l+"["+t+"]"):"boolean"==typeof e[t]?n+=$("<div>").append($('<input type="hidden">').attr("name",null==l?t+"":l+"["+t+"]").val(e[t]?"true":"false")).html():"number"==typeof e[t]?n+=$("<div>").append($('<input type="hidden">').attr("name",null==l?t+"":l+"["+t+"]").val(e[t]+"")).html():"string"==typeof e[t]&&(n+=$("<div>").append($('<input type="hidden">').attr("name",null==l?t+"":l+"["+t+"]").val(e[t])).html());return n}function f(e,l,n){(void 0===n||null===n||""===n)&&(n=null);for(var t in l)void 0===l[t]||null===l[t]?e.append(null==n?t+"":n+"["+t+"]",""):"object"==typeof l[t]?f(e,l[t],null==n?t+"":n+"["+t+"]"):"boolean"==typeof l[t]?e.append(null==n?t+"":n+"["+t+"]",l[t]?"true":"false"):"number"==typeof l[t]?e.append(null==n?t+"":n+"["+t+"]",l[t]+""):"string"==typeof l[t]&&e.append(null==n?t+"":n+"["+t+"]",l[t])}function u(e){return R[e].state}function d(e,l){var n="";if(0==l)n="init";else if(1==l)n="uploading";else if(2==l)n="success";else if(3==l)n="error";else{if(4!=l)return!1;n="cancel"}R[e].state=l,A[e].upload.state=n}function m(e){var l=e.lastIndexOf(".");return-1!=l?e.substr(l+1):""}function c(e,n){if(void 0!=n&&null!=n){var t=n.name;if(void 0!=t&&null!=t&&""!=t){var a=m(t).toLowerCase();if(""!=a){var o=!1;for(var r in e)if(e[r].toLowerCase()==a){o=!0;break}return o?!0:!1}return!1}}if("object"!=typeof l||null===l)return!0;var i=l.value;if(""!=i){var a=m(i).toLowerCase();if(""!=a){var o=!1;for(var r in e)if(e[r].toLowerCase()==a){o=!0;break}if(o)return!0}}return!1}function v(e,l){if(void 0!=l&&null!=l){var n=l.type;if(void 0!=n&&null!=n&&""!=n){n=n.toLowerCase();var t=!1;for(var a in e)if(e[a].toLowerCase()==n){t=!0;break}return t?!0:!1}}return!0}function h(e,l){if(void 0!=l&&null!=l){var n=l.size;if(void 0!=n&&null!=n&&""!=n&&y(n))return e>=n?!0:!1}return!0}function y(e){return isNaN(e)||parseInt(e)+""!=e?!1:!0}function g(e){var l=document.createElement("a");l.href=e;var n=l.host,t=l.protocol;return""==n&&(n=window.location.host),(""==t||":"==t)&&(t=window.location.protocol),t.replace(/\:$/,"")+"://"+n}var U=!1,b=null,w=0,x=0,j=[],k=[],E="auto",S=null,z=null,C="file",F={},T={},I=function(){},L=function(){},q=function(){},W=function(){},_=function(){},M=function(){},D=function(){},N=function(){},A=[],R=[],O={files:A},B=0,J=null,Q=function(e,l){V(e,l),B--,0==B&&Z(),simpleUpload.activeUploads--,simpleUpload.uploadNext()},H=function(e){return I.call(O,e)},X=function(e,l){return u(e)>0?!1:L.call(A[e],l)===!1?(d(e,4),!1):u(e)>0?!1:void d(e,1)},Y=function(e,l){1==u(e)&&q.call(A[e],l)},G=function(e,l){1==u(e)&&(d(e,2),W.call(A[e],l),Q(e,"success"))},K=function(e,l){1==u(e)&&(d(e,3),_.call(A[e],l),Q(e,"error"))},P=function(e){M.call(A[e]),Q(e,"cancel")},V=function(e,l){D.call(A[e],l)},Z=function(){N.call(O),null!=J&&J.remove()};t()}simpleUpload.maxUploads=10,simpleUpload.activeUploads=0,simpleUpload.uploads=[],simpleUpload.iframes={},simpleUpload.iframeCount=0,simpleUpload.queueUpload=function(e,l){simpleUpload.uploads[simpleUpload.uploads.length]={uploads:e,callback:l}},simpleUpload.uploadNext=function(){if(simpleUpload.uploads.length>0&&simpleUpload.activeUploads<simpleUpload.maxUploads){var e=simpleUpload.uploads[0],l=e.callback,n=e.uploads.splice(0,1)[0];0==e.uploads.length&&simpleUpload.uploads.splice(0,1),simpleUpload.activeUploads++,l(n),simpleUpload.uploadNext()}},simpleUpload.queueIframe=function(e){for(var l=0;0==l||l in simpleUpload.iframes;)l=Math.floor(999999999*Math.random()+1);return simpleUpload.iframes[l]=e,simpleUpload.iframeCount++,$("body").append('<iframe name="simpleUpload_iframe_'+l+'" style="display: none;"></iframe>'),l},simpleUpload.dequeueIframe=function(e){e in simpleUpload.iframes&&($("iframe[name=simpleUpload_iframe_"+e+"]").remove(),delete simpleUpload.iframes[e],simpleUpload.iframeCount--)},simpleUpload.convertDataType=function(e,l,n){var t="auto";if("auto"==e){if("string"==typeof l&&""!=l){var a=l.toLowerCase(),o=["json","xml","html","script","text"];for(var r in o)if(o[r]==a){t=a;break}}}else t=e;if("auto"==t)return"undefined"==typeof n?"":"object"==typeof n?n:String(n);if("json"==t){if("undefined"==typeof n||null===n)return null;if("object"==typeof n)return n;if("string"==typeof n)try{return $.parseJSON(n)}catch(i){return!1}return!1}if("xml"==t){if("undefined"==typeof n||null===n)return null;if("string"==typeof n)try{return $.parseXML(n)}catch(i){return!1}return!1}if("script"==t){if("undefined"==typeof n)return"";if("string"==typeof n)try{return $.globalEval(n),n}catch(i){return!1}return!1}return"undefined"==typeof n?"":String(n)},simpleUpload.iframeCallback=function(e){if("object"==typeof e&&null!==e){var l=e.id;if(l in simpleUpload.iframes){var n=simpleUpload.convertDataType(simpleUpload.iframes[l].expect,e.type,e.data);n!==!1?simpleUpload.iframes[l].complete(n):simpleUpload.iframes[l].error("Could not get response from server")}}},simpleUpload.postMessageCallback=function(e){try{var l=e.message?"message":"data",n=e[l];if("string"==typeof n&&""!=n&&(n=$.parseJSON(n),"object"==typeof n&&null!==n&&"string"==typeof n.namespace&&"simpleUpload"==n.namespace)){var t=n.id;if(t in simpleUpload.iframes&&e.origin===simpleUpload.iframes[t].origin){var a=simpleUpload.convertDataType(simpleUpload.iframes[t].expect,n.type,n.data);a!==!1?simpleUpload.iframes[t].complete(a):simpleUpload.iframes[t].error("Could not get response from server")}}}catch(e){}},window.addEventListener?window.addEventListener("message",simpleUpload.postMessageCallback,!1):window.attachEvent("onmessage",simpleUpload.postMessageCallback),function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){e.fn.simpleUpload=function(l,n){return 0==e(this).length&&"object"==typeof n&&null!==n&&"object"==typeof n.files&&null!==n.files?(new simpleUpload(l,null,n),this):this.each(function(){new simpleUpload(l,this,n)})},e.fn.simpleUpload.maxSimultaneousUploads=function(e){return"undefined"==typeof e?simpleUpload.maxUploads:"number"==typeof e&&e>0?(simpleUpload.maxUploads=e,this):void 0}});



(function($){
        $.fn.ajax_upload = function(url){
		var $_this = $(this);
		var _files = this.files = [];
		var $_input = null;
		var $_input_wrapper = $('<div>').appendTo($_this);
		var $_percent_span = null;
		var _add_input = function(){
			$_input = $('<input>').attr('type', 'file').attr('name', 'ajax-upload-file').attr('multiple', true)/*.attr('accept', "image/*")*/.hide().change(function(){
				_input_change();
			}).appendTo($_input_wrapper);
		}
		_add_input();
		$_this.addClass('ajax-upload');
		var $_select_link =$('<a>').attr('href','javascript:void(0)').html('Click to select file(s)').appendTo($_this);
		var $_loading_icon = $('<span>').css('margin-left', '20px').appendTo($_this);
		$_upload_status = $('<div>').addClass('row').appendTo($_this);

		$_select_link.click(function(){
			$_input.click();
		});
		
		var _change_callback = null;
	
		this.change = function(param){
			_change_callback = param;
		};
		
		var _input_change = function(){
			var upload_error = false;
			$_input.simpleUpload(url, {
				start: function(file){
					$_loading_icon.removeClass('text-danger').removeClass('text-success').html('<i class="fa fa-spinner fa-spin fa-fw"></i>');
					var $_upload_status_block_wrapper = $('<div>').addClass('col-lg-12').addClass('col-md-12').addClass('small').appendTo($_upload_status);
					var $_upload_status_block = $('<div>').addClass('clearfix').css('margin', '2px 0').css('padding', '5px').css('border', '1px solid #d5d5d5').appendTo($_upload_status_block_wrapper);
					var top = $('<div>').addClass('clearfix').appendTo($_upload_status_block);
					$('<div>').addClass('pull-right').addClass('clearfix').outerWidth('20px').append('<a href="javascript:void(0)" class="pull-right"><span class="glyphicon glyphicon-remove ajax-upload-file-remove"></span></a>').appendTo(top); 
					var $_name_div = $('<div>').css('overflow', 'hidden').css('white-space', 'nowrap').css('text-overflow', 'ellipsis').append('<span>' + file['name'] + '</span>').appendTo(top);
					$_percent_span = $('<span></span>').appendTo($_name_div);
					this.progress_bar = $('<div>').addClass('progress-bar').addClass('progress-bar-success').addClass("notransition").css('width', '1%').css('margin-top', '5px').outerHeight('20px').html('0%').appendTo($_upload_status_block);
				},

				progress: function(progress){
					if(upload_error){
						$('#uploaded-progress-bar .progress-bar').attr('aria-valuenow', 0).css('width', 0).html(0);
						$_percent_span.css('color', 'red').html(' - Error');
					}
					else{
						this.progress_bar.css('width', progress + '%');
						//$_percent_span.css('color', 'black').html(' - ' + progress + '%');
						this.progress_bar.html(Math.round(progress) + '%');
					}
				},

				success: function(data){
					data = JSON.parse(data);
					if(data['success']){
						$('#uploaded-progress-bar .progress-bar').addClass('progress-bar-success');
						var file = data['data'];
						_files.push(file);
						if(_change_callback){
							_change_callback(_files);
						}
						$_loading_icon.addClass('text-success').html('Succeeded to upload file.');
					}
					else{
						$_loading_icon.addClass('text-danger').html(data['error']);
					}
				},

				error: function(error){
					$_loading_icon.addClass('text-danger').html('Failed to upload file');
				}
			}).remove();
			$_input = null;
			$_input_wrapper.empty();
			_add_input();;
		};
		
		$_this.delegate('.ajax-upload-file-remove', 'click', function(){
			//_files[]
		})
		return this;
	}
}(jQuery));
 