<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
		<title>SMD - Lily Fortune Club</title>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/jquery-ui-1.11.4/jquery-ui.css" />
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/bootstrap-4.1.3-dist/css/bootstrap.min.css" />
		<link rel="icon" type="image/png/ico" href="<?php echo base_url();?>src/img/smd.ico">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/jquery-simple-datetimepicker/jquery.datetimepicker.css?t=<?php echo time();?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/dialog/dialog.css?t=<?php echo time();?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/data_table/data_table.css?t=<?php echo time();?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/tree_grid/tree_grid.css?t=<?php echo time();?>">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/font-awesome-4.7.0/css/font-awesome.min.css" />		
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/css/smd/template.css?t=<?php echo time();?>" />		
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/css/smd/team.css?t=<?php echo time();?>" />		
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/bootstrap-select-1.13.2/css/bootstrap-select.min.css?t=<?php echo time();?>" />		
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/fullcalendar-3.9.0/fullcalendar.min.css?t=<?php echo time();?>" />		
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/fullcalendar-3.9.0/scheduler.min.css?t=<?php echo time();?>" />		
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-migrate-1.2.1.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-ui-1.11.4/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/popper.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootbox.min.js"></script>		
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/moment.min.js"></script>		
		<script src="<?php echo base_url();?>src/3rd_party/jquery-simple-datetimepicker/jquery.datetimepicker.full.min.js?t=<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/dialog/dialog.js?t=<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/data_table/data_table.js?t=<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/dialog_toggle.js?t=<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/ajax_upload/ajax_upload.js?t=<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/js/tools.js?t=<?php echo time();?>"></script>		
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/tree_grid/tree_grid.js?t=<?php echo time();?>"></script>		
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/Chart.bundle.min.js?t=<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/simple_video_player/simple_video_player.js?t=<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jstz.js"></script>
		<script src="<?php echo base_url();?>src/3rd_party/ckeditor/ckeditor.js"></script>
		<script src="<?php echo base_url();?>src/3rd_party/bootstrap-select-1.13.2/js/bootstrap-select.min.js?<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/fullcalendar-3.9.0/fullcalendar.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/fullcalendar-3.9.0/scheduler.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/dropdownedit/dropdownedit.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/angular.min.js"></script>
		<script>
		$('document').ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
		});
		</script>
	</head>
	<body>
		<?php
			$this->load->view('smd/processing');
		?>
		<?php $this->load->view('smd/header', $this->_ci_cached_vars);?>
		
		<div id="main-body-container">
			<div class="bg-secondary">
				<ul class="nav-left">
					<?php 
						foreach($nav_menus as $menu_name => $menu){
							if(array_key_exists('active', $menu) && $menu['active']){
								foreach($menu['sub_menus'] as $sub_menu_name=> $sub_menu){
						?>
						<a href="<?php echo base_url().'smd/'.$menu_name.'/'.$sub_menu_name;?>">
						<li <?php echo array_key_exists('active', $sub_menu) && $sub_menu['active'] ? 'class="active"' : ''; ?>><?php echo $sub_menu['text'];?></li>
						</a>
						<?php
								}
								break;
							}
						}
						?>
					</ul>
				</div>
				<div id="main-body-wrapper">
					<?php $this->load->view("smd/$view", $this->_ci_cached_vars);?>
				</div>
			</div>
			<!--/div-->			
		
	</body>
</html>