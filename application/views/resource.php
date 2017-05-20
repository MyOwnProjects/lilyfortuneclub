<style>
.resource-list .resource-list-thumbnail{width:118px;height:69px;border:1px solid #efefef;margin-right:20px;text-align:center;padding:2px}
.resource-list .resource-list-thumbnail img{width:112px;height:63px;display:inline;}
.resource-list ul:not(.breadcrumb){list-style:none !important}
.resource-list ul:not(.breadcrumb) li{margin:0 20px;line-height:30px;padding:20px 0}
.resource-list ul:not(.breadcrumb) li:not(:first-child){border-top:1px solid #efefef}
.resource-list li .resource-list-info{color:#888}
.resource-list-subject{font-weight:bold;overflow:hidden}
.resource-list-subject .resource-list-info{font-weight:normal}
.resource-list-short-desc{line-height:20px;height:40px;font-size:12px;overflow:hidden;overflow:hidden}
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
<div class="resource-list  main-content-wrapper">
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url();?>">Home</a></li>
		<li class="active">Resource</li> 
	</ul>
	<ul id="resource-list">
		<li style="text-align:center;line-height:160px;"><img src="<?php echo base_url();?>src/img/spinning.gif"></li>
	</ul>
</div>
<script>
$.ajax({
	url: '<?php echo base_url();?>resource/get_list',
	dataType: 'json',
	success:function(data){
		if(data.length == 0){
			$('#resource-list li').html('No resources.');
			return false;
		}
		var $_resource_list = $('#resource-list').empty();
		for(var i = 0; i < data.length; ++i){
			var content_wrapper = $('<div>').append(data[i]['content']);
			var $_li = $('<li>');
			var $_a = $('<a>').attr('href', '<?php echo base_url();?>resource/item/' + data[i]['url_id']).attr('target', '_blank');
			var img_wrappers = content_wrapper.children('.content-image');
			var $_thumbnail = $('<div>').addClass('pull-left').addClass('resource-list-thumbnail').appendTo($_li);
			if(img_wrappers.length > 0){
				$_a.clone().append('<img src="' + $(img_wrappers[0]).children('img').attr('src') + '">').appendTo($_thumbnail);
			}
			var $_subject = $('<div>').addClass('resource-list-subject').appendTo($_li);
			$('<span>').append($_a.clone().append(data[i]['subject'])).appendTo($_subject);
			var date = data[i]['create_time'].split(' ');
			$('<span>').addClass('resource-list-info').append('&nbsp;(' + date[0] + ')').appendTo($_subject);

			var $_desc = $('<div>').addClass('resource-list-short-desc').html(content_wrapper.text()).appendTo($_li);
			$_li.appendTo($_resource_list);
		}
	},
	error: function(){
		$('#resource-list li').html('No resources.');
	}
});
</script>
