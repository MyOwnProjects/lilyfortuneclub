<link type="text/css" rel="Stylesheet" href="<?php echo base_url();?>src/css/scheduler.css" />
<script type="text/javascript" src="<?php echo base_url();?>src/js/scheduler.js"></script>
<div id="smd-scheduler"></div>
<script>
	$('#smd-scheduler').scheduler('<?php echo base_url();?>smd/scheduler', '#modal-processing');
</script>