<div data-role="page" id="resource-item" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => $resource['subject'].' - Lily Fortune Club'));?>
	<div data-role="main" class="ui-content">
		<div class="resource-content">
			<h4><?php echo $resource['subject'];?></h4>
			<p><?php echo date_format(date_create($resource['create_time']), 'M d, Y H:i').", ".$resource['source'];?></p>
			<div><?php echo $resource['content'];?></div>
		</div>
	</div>
</div>
