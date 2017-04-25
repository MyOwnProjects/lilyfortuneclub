<style>
#live-chat{position:fixed;background:#fff;opacity:1;right:0;bottom:0}	
#live-chat #messages>div{font-size:14px;line-height:20px;}
</style>

<div id="live-chat">
	<div class="panel panel-success">
		<div class="panel-heading clearfix">
			Live Chatsfds
			<span class="pull-right" style="cursor:pointer" onclick="toggle_chat();">&#2715;</span>
		</div>
		<div class="panel-body">
			<div id="messages" style="width:400px;height:200px;border:1px solid #d5d5d5;background:#fff;opacity:1;overflow-y:auto;overflow:hidden">
				
			</div>
		</div>
		<div class="panel-footer clearfix">
			<textarea style="width:100%;height:50px;box-sizing:border-box;"></textarea>
			<button class="pull-right btn btn-sm btn-success" onclick="send_message_ex()">Send</button>
		</div>
	</div>
</div>

<script>
function send_message_ex(){
	var message = $('#live-chat textarea').val().trim();
	if(message.length > 0){
		var now = new Date();
		$.ajax({
			url: '<?php echo base_url();?>chat',
			method: 'post',
			dataType: 'json',
			data: {message: message},
			success: function(data){
				if(!$.isEmptyObject(data)){
					var span = $('<span>').css("font-weight", "bold");
					if(data['sender'] == 'guest'){
						span.addClass("text-danger").html('Me');
					}
					else{
						span.addClass("text-success").html('SMD');
					}
					var d = $('<div>').append(span).append('(' + data['time'] + '): ' + message);
					$('#live-chat #messages').append(d);
				}
			},
			error: function(a, b, c){
				
			}
		});
	}
	$('#live-chat textarea').val('');
}
$('body').delegate('#live-chat textarea', 'keyup', function(e){
	if(e.which == 13){
		send_message_ex();
	}
	e.stopPropagation();
	return false;
});
(function($){
	$.ajax({
		url: '<?php echo base_url();?>chat',
		method: 'post',
		dataType: 'json',
		data: {message: message},
		success: function(data){
			if(!$.isEmptyObject(data)){
				var span = $('<span>').css("font-weight", "bold");
				if(data['sender'] == 'guest'){
					span.addClass("text-danger").html('Me');
				}
				else{
					span.addClass("text-success").html('SMD');
				}
				var d = $('<div>').append(span).append('(' + data['time'] + '): ' + message);
				$('#live-chat #messages').append(d);
			}
		},
		error: function(a, b, c){
			
		}
	});
}(jQuery));
</script>
