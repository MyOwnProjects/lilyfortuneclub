<style>
.resource-subject{text-align:center;font-weight:bold}
.resource-info{text-align:center}
.resource-content{padding:40px 0;line-height:25px;}
.resource-content .content-image{text-align:center;margin:40px auto} 
.resource-content img{width:100%;max-width:600px}
@media only screen and (max-width:800px) {
.resource-subject, .resource-info{text-align:left;font-weight:normal}
}
</style>
<script>
	var o_width, o_height;
	$(window).resize(function(){
		var frame = $('.youtube-link');
		frame.innerHeight(frame.innerWidth() * o_width / o_height) ;
	});
$(document).ready(function(){
	var frame = $('.youtube-link');
	o_width = parseInt(frame.attr('width'));
	o_height = parseInt(frame.attr('height'));
	frame.removeAttr('width').removeAttr('height').css('width', '100%').css('max-width', o_width + 'px');
});
</script>
<div class="resource main-content-wrapper">
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url();?>">Home</a></li>
		<li><a href="<?php echo base_url();?>resource">Resource</a></li> 
		<li class="active">Item</li> 
	</ul>

	<h3 class="resource-subject"><?php echo $resource['subject'];?></h3>
	<div class="resource-info"><span><?php echo date_format(date_create($resource['create_time']), 'm/d/Y');?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $resource['source'];?></span></div>
	<div class="resource-content"><?php echo $resource['content'];?></div>
</div>