<style>
	#resource-list{margin:0;padding:0}
.resource-list .resource-list-thumbnail{width:118px;height:69px;border:1px solid #efefef;margin-right:20px;text-align:center;padding:2px}
.resource-list .resource-list-thumbnail-blank img{opacity:0.2}
.resource-list .resource-list-thumbnail img{width:112px;height:63px;display:inline;}
.resource-list ul:not(.breadcrumb){list-style:none !important}
.resource-list ul:not(.breadcrumb) li{margin:0 20px;line-height:30px;padding:20px 0}
.resource-list ul:not(.breadcrumb) li:not(:first-child){border-top:1px solid #efefef}
.resource-list li .resource-list-info{color:#888}
.resource-list-subject{font-weight:bold;overflow:hidden}
.resource-list-subject .resource-list-info{font-weight:normal}
.resource-list-short-desc{line-height:20px;height:40px;font-size:12px;overflow:hidden}
@media only screen and (max-width:768px) {
.main-content-wrapper{padding:20px 0}
.resource-list li .resource-list-info{display:none}
#resource-list li:last-child{border-bottom:1px solid #efefef}
.resource-list-subject{font-weight:normal;overflow:hidden;white-space:nowrap;text-overflow:ellipsis}
.resource-list #resource-list{list-style:none !important;padding:0}
#resource-list li{list-style:none;padding:20px;margin:0}
}
</style>
<div class="resource-list  main-content-wrapper">
	<div class="clearfix" style="border-bottom:1px solid #e5e5e5;padding:5px 20px">
		<div class="pull-right">
			<form>
				<label class="radio-inline">
					<input type="radio" name="language" value="EN" <?php echo $language == 'EN' ? 'checked' : ''?>>English
				</label>
				<label class="radio-inline">
					<input type="radio" name="language" value="CN" <?php echo $language == 'CN' ? 'checked' : ''?>>中文
				</label>
			</form>
		</div>
	</div>
	<ul id="resource-list">
	</ul>
</div>
<script>
$('input[name=language]').change(function(){
	get_resource_list($(this).val());
});
function get_resource_list(lan){
	var $_resource_list = $('#resource-list');
	$_resource_list.empty().append('<li style="text-align:center;line-height:160px;"><img src="<?php echo base_url();?>src/img/spinning.gif"></li>');
	$.ajax({
		url: '<?php echo base_url();?>resource/get_list',
		data: {language: lan},
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
				var href = '<?php echo base_url();?>resource/item/' + data[i]['url_id'];
				if(data[i]['source_url'] && data[i]['source_url'].trim().length > 0){
					href= data[i]['source_url'];
				}
				var $_a = $('<a>').addClass('text-link').attr('href', href).attr('target', '_blank');
				var img_wrappers = content_wrapper.find('.content-image');
				var $_thumbnail = $('<div>').addClass('pull-left').addClass('resource-list-thumbnail').appendTo($_li);
				if(img_wrappers.length > 0){
					$_a.clone().append('<img src="' + $(img_wrappers[0]).children('img').attr('src') + '">').appendTo($_thumbnail);
				}
				else{
					$_thumbnail.addClass('resource-list-thumbnail-blank');
					$_a.clone().append('<img src="<?php echo base_url();?>src/img/lfc2.png">').appendTo($_thumbnail);
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
}

get_resource_list($('input[name=language]:checked').val());
</script>
