<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"></meta>
		<title>SMD - Lily Fortune Club</title>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/jquery-ui-1.11.4/jquery-ui.css" />
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/css/bootstrap.min.css" />
		<link rel="icon" type="image/png/ico" href="<?php echo base_url();?>src/img/smd.ico">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/jquery-simple-datetimepicker/jquery.datetimepicker.css?t=<?php echo time();?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/dialog/dialog.css?t=<?php echo time();?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/data_table/data_table.css?t=<?php echo time();?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/tree_grid/tree_grid.css?t=<?php echo time();?>">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/font-awesome-4.7.0/css/font-awesome.min.css" />		
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/css/smd/template.css?t=<?php echo time();?>" />		
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/css/smd/team.css?t=<?php echo time();?>" />		
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/bootstrap-select-master/css/bootstrap-select.min.css?t=<?php echo time();?>" />		
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-migrate-1.2.1.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-ui-1.11.4/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootbox.min.js"></script>		
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
		<script src="<?php echo base_url();?>src/3rd_party/bootstrap-select-master/js/bootstrap-select.min.js"></script>
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
		
		<div>
				<div style="position:fixed;top:52px;width:150px;bottom:0;left:0;background:#f1f1f1;padding-top:20px">
					<ul class="side-nav-left nav nav-pills nav-stacked">
						<?php 
						foreach($nav_menus as $menu_name => $menu){
							if(array_key_exists('active', $menu) && $menu['active']){
								foreach($menu['sub_menus'] as $sub_menu_name=> $sub_menu){
						?>
						<li <?php echo array_key_exists('active', $sub_menu) && $sub_menu['active'] ? 'class="active"' : ''; ?>><a href="<?php echo base_url().'smd/'.$menu_name.'/'.$sub_menu_name;?>"><?php echo $sub_menu['text'];?></a></li>
						<?php
								}
								break;
							}
						}
						?>
					</ul>
				</div>
				<div id="main-body-wrapper" style="position:fixed;top:52px;right:0px;bottom:0;left:150px;overflow:auto">
					<?php $this->load->view("smd/$view", $this->_ci_cached_vars);?>
				</div>
			</div>			
		</div>
	</body>
</html>