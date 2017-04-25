var Dialog = function(){
};

Dialog.modal = function(option){
	var loading_div = $('<div>').addClass('dialog-bootbox-loading').addClass('alert').css('text-align', 'center').append('<div></div>').hide();
	var result_div = $('<div>').addClass('dialog-bootbox-result').addClass('alert').hide();
	
	Dialog.modal.box = bootbox.dialog({
		message: $('<div>').append(loading_div.clone()).append(result_div.clone()).html() + option['message'],
		title: option['title'],
		buttons: option['buttons']
	});
	Dialog.modal.loading = $('.dialog-bootbox-loading');
	Dialog.modal.result = $('.dialog-bootbox-result');
	Dialog.modal.statusCode = [];
	if(option && option['redirect']){
		for(var code in option['redirect']){
			Dialog.model.redirect.push({statusCode: code, url: option['redirect'][code]});
		}
	}
};
Dialog.modal.box = null;
Dialog.modal.loading = null;
Dialog.modal.result = null;

Dialog.modal.ajaxLoad = function(callback){
	var valid = true;
	Dialog.modal.box.find('input, select').removeClass('dialog-bootbox-error').each(function(index, obj){
		if(!obj.checkValidity()){
			valid = false;
			$(obj).addClass('dialog-bootbox-error');//css('background', '#f2dede');
		}
	}).change(function(){
		$(this).removeClass('dialog-bootbox-error');
	});
	
	if(valid){
		Dialog.modal.result.hide().empty();
		Dialog.modal.loading.show();
		if(callback && $.isFunction(callback)){
			callback();
		}
	}
};

Dialog.modal.error = function(message, callback){
	Dialog.modal.loading.hide();
	Dialog.modal.result.removeClass('alert-success').addClass('alert-danger').html(message).show();
	if(callback && $.isFunction(callback)){
		callback();
	}
};

Dialog.modal.success = function(message, callback){
	Dialog.modal.loading.hide();
	Dialog.modal.result.removeClass('alert-danger').addClass('alert-success').html(message).show();
	if(callback && $.isFunction(callback)){
		callback();
	}
};

Dialog.hide = function(callback){
	Dialog.modal.box.modal('hide');
	if(callback && $.isFunction(callback)){
		callback();
	}
};

Dialog.error = function(message){
	bootbox.alert(message);
};

