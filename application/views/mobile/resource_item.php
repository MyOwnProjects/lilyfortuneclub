<script>
var o_width, o_height;
$(window).resize(function(){
	var frame = $('.youtube-link');
	frame.innerHeight(frame.innerWidth() *  o_height / o_width) ;
});
$(document).ready(function(){
	var frame = $('.youtube-link');
	o_width = parseInt(frame.attr('width'));
	o_height = parseInt(frame.attr('height'));
	frame.removeAttr('width').removeAttr('height').css('width', '100%').css('max-width', o_width + 'px');
	alert(o_width);
	frame.innerHeight(frame.innerWidth() *  o_height / o_width) ;
});
</script>
<div data-role="page" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => $resource['subject'].' - Lily Fortune Club'));?>
	<div data-role="main" class="ui-content">
		<div class="resource-content">
			<h4><?php echo $resource['subject'];?></h4>
			<p><?php echo date_format(date_create($resource['create_time']), 'M d, Y H:i').", ".$resource['source'];?></p>
			<div><?php echo $resource['content'];?></div>
		</div>
	</div>
</div>
