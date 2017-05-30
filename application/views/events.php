<style>
#event-list{padding:0;margin:0}
.event-list .event-list-thumbnail{width:118px;height:69px;border:1px solid #efefef;margin-right:20px;text-align:center;padding:2px}
.event-list .event-list-thumbnail img{width:112px;height:63px;display:inline;}
.event-list ul:not(.breadcrumb){list-style:none !important}
.event-list ul:not(.breadcrumb) li{margin:0 20px;line-height:30px;padding:20px 0}
.event-list ul:not(.breadcrumb) li:not(:first-child){border-top:1px solid #efefef}
.event-list li .event-list-info{color:#888}
.event-list-subject{font-weight:bold;overflow:hidden}
.event-list-subject .event-list-info{font-weight:normal}
.event-list-short-desc{line-height:20px;height:40px;font-size:12px;overflow:hidden;overflow:hidden}
@media only screen and (max-width:600px) {
.resource-list .resource-list-thumbnail{display:none}
.resource-list li .resource-list-info{display:none}
.resource-list-short-desc{display:none}
.resource-list-subject{font-weight:normal;overflow:visible}
.resource-list #resource-list{list-style:none !important;padding:0}
.resource-list #resource-listul li{list-style:none;padding:0}
.resource-list ul:not(.breadcrumb) li:not(:first-child){border-top:none}
}
</style>
<div class="event-list  main-content-wrapper">
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url();?>">Home</a></li>
		<li class="active">Seminar</li> 
	</ul>
	<ul id="event-list">
		<li style="text-align:center;line-height:160px;"><img src="<?php echo base_url();?>src/img/spinning.gif"></li>
	</ul>
</div>
<script>
$.ajax({
	url: '<?php echo base_url();?>events/get_list',
	dataType: 'json',
	success:function(data){
		if(data.length == 0){
			$('#event-list li').html('No events.');
			return false;
		}
		var $_event_list = $('#event-list').empty();
		for(var i = 0; i < data.length; ++i){
			var content_wrapper = $('<div>').append(data[i]['events_detail']);
			var $_li = $('<li>');
			var $_a = $('<a>').attr('href', '<?php echo base_url();?>events/item/' + data[i]['events_id']).attr('target', '_blank');
			var img_wrappers = content_wrapper.children('.content-image');
			var $_thumbnail = $('<div>').addClass('pull-left').addClass('event-list-thumbnail').appendTo($_li);
			if(img_wrappers.length > 0){
				$_a.clone().append('<img src="' + $(img_wrappers[0]).children('img').attr('src') + '">').appendTo($_thumbnail);
			}
			var $_subject = $('<div>').addClass('event-list-subject').appendTo($_li);
			$('<span>').append($_a.clone().append(data[i]['events_subject'])).appendTo($_subject);
			var date = data[i]['events_start_time'].split(' ');
			var city = data[i]['events_city'] + ', ' + data[i]['events_state'];
			//$('<span>').addClass('event-list-info').append('&nbsp;(' + date[0] + ')').appendTo($_subject);

			var $_desc = $('<div>').addClass('event-list-short-desc').html('Location: ' + city + '.<br/>Time: ' + date[0]).appendTo($_li);
			$_li.appendTo($_event_list);
		}
	},
	error: function(){
		$('#event-list li').html('No events.');
	}
});
</script>
