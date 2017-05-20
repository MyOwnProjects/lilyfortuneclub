<div data-role="page" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'Resource'));?>
	<div data-role="main" class="ui-content">
		<div class="resource-content">
			<h4><?php echo $resource['subject'];?></h4>
			<p><?php echo date_format(date_create($resource['create_time']), 'M d, Y H:i').", ".$resource['source'];?></p>
			<div><?php echo $resource['content'];?></div>
		</div>
	</div>
</div>
