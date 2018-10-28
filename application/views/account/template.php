<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"></meta>
		<title></title>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/jquery-ui-1.11.4/jquery-ui.css" />
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/dialog/dialog.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/data_table/data_table.css">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/css/smd/template.css" />		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/plyr-master/dist/plyr.css?<?php echo time();?>">
		<script src="<?php echo base_url();?>src/3rd_party/plyr-master/dist/plyr.js?<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-migrate-1.2.1.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-ui-1.11.4/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootbox.min.js"></script>		
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/dialog/dialog.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/data_table/data_table.js?t=<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/js/tools.js"></script>		
		<script>
		$(document).ready(function(){
			
		});
		</script>
	</head>
	<body>
		<div>
		<?php $this->load->view('header', $this->_ci_cached_vars);?>
		</div>
		<div>
			<div style="position:absolute;top:52px;right:0;bottom:0;;left:0;bottom:0;">
				<div style="position:absolute;top:0;width:150px;bottom:0;left:0;border-right:1px solid #e7e7e7;padding-top:20px">
					<ul class="side-nav-left">
						<a href="<?php echo base_url();?>smd/schedule"><li>Schedule</li></a>
						<a href="<?php echo base_url();?>smd/team"><li>Team</li></a>
						<a href="<?php echo base_url();?>smd/team/new_member"><li>New Member</li></a>
						<a href="<?php echo base_url();?>smd/document"><li>Document</li></a>
					</ul>
				</div>
				<div style="position:absolute;top:0;right:0px;bottom:0;left:150px;padding:20px;">
					<?php $this->load->view("account/$view", $this->_ci_cached_vars);?>
				</div>
			</div>			
		</div>
	</body>
</html>