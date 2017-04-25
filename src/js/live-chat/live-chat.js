(function($){
	$.fn.live_chat = function(prop){
		var _this = $(this);
		var $_this = $(this).css('z-index', '10000').css('position', 'fixed').css('right', '0').css('bottom', '0').css('background', 'rgba(255, 255, 255, 0)');

		var $_panel = $('<div>').addClass('panel').addClass('panel-primary').css('background', '#fff').css('opacity','1').appendTo($_this);
		var $_panel_heading = $('<div>').addClass('panel-heading').addClass('clearfix').appendTo($_panel);
		var $_panel_close_button = $('<span>').addClass('pull-right').css('cursor','pointer').html("&#x2715;").appendTo($_panel_heading).click(function(){
			$_this.slideToggle();
		});
		$_panel_heading.append('Live Chat');
		var $_panel_body = $('<div>').addClass('panel-body').addClass('clearfix').appendTo($_panel);
		var $_messages = $('<div>').css('padding', '5px').css('width','400px').css('height', '200px').css('border', '1px solid #d5d5d5').css('overflow-y', 'auto').css('overflow-x', 'hidden').css('font-size', '14px').css('line-height', '20px').appendTo($_panel_body);
		var $_panel_footer = $('<div>').addClass('panel-footer').addClass('clearfix').appendTo($_panel);
		var $_textarea = $('<textarea>').css('width', '100%').css('height', '50px').css('box-sizing', 'border-box').appendTo($_panel_footer);
		$('<button>').addClass('pull-right').addClass('btn').addClass('btn-sm').addClass('btn-success').appendTo($_panel_footer).html('Send').click(function(){
			send_message();
		});
		
		var session_id = '';
		var send_message = function(){
			var message = $_textarea.val().trim();
			if(message.length > 0){
				$.ajax({
					url: prop['url'] + '?session=' + session_id,
					method: 'post',
					dataType: 'json',
					data: {message: message},
					success: function(data){
						if(!$.isEmptyObject(data)){
							if(!session_id){
								session_id = data['session'];
							}
							else if(session_id != data['session']){
								return false;
							}
							var span = $('<span>').css("font-weight", "bold");
							if(data['sender'] == 'guest'){
								span.addClass("text-danger").html('Me');
							}
							else{
								span.addClass("text-success").html(data['sender']);
							}
							var d = $('<div>').append(span).append('(' + data['time'] + '): ' + data['message']);
							$_messages.append(d);
						}
					},
					error: function(a, b, c){

					}
				});
			}
			$('#live-chat textarea').val('');
		};
		
		var receive_message = function(){
			if(session_id){
				$.ajax({
					url: prop['url'] + '?session=' + session_id,
					method: 'get',
					dataType: 'json',
					success: function(data){
						if(!$.isEmptyObject(data)){
							if(session_id == data['session']){
								for(var i = 0; i < data['messages'].length; ++i){
									var messages = data['messages'][i];
									var span = $('<span>').css("font-weight", "bold").addClass("text-success").html(data['respondent']);
									var d = $('<div>').append(span).append('(' + messages['time'] + '): ' + messages['message']);
									$_messages.append(d);
								}
							}
						}

					},
					error: function(a, b, c){
					}
				});
			}
			window.setTimeout(receive_message, 5000);
		};
		
		$('body').delegate('textarea', 'keyup', function(e){
			if(e.target === $_textarea[0]){
				if(e.which == 13){
					send_message();
				}
				e.stopPropagation();
				return false;
			}
		});
			
		receive_message();
		$_this.hide();
		return $_this;
	};
})(jQuery);

