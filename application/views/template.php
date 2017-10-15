<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
		<title><?php echo empty($web_title) ? "Lily Fortune Club" : $web_title; ?></title>
		<link href='http://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
		<link rel="icon" type="image/png/ico" href="<?php echo base_url();?>src/img/lfc.ico">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/jquery-ui-1.11.4/jquery-ui.css" />
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/css/bootstrap.css?<?php time();?>" />
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/jquery.bootgrid-1.3.1/jquery.bootgrid.css" />		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/dialog/dialog.css?t=<?php echo time();?>">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/jquery.webui-popover/jquery.webui-popover.css" />		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/css/tooltip.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/3rd_party/tree_grid/tree_grid.css?t=<?php echo time();?>">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/css/template.css?t=<?php echo time();?>" />		
		<link rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/font-awesome-4.7.0/css/font-awesome.min.css">
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-migrate-1.2.1.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-ui-1.11.4/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootbox.min.js"></script>		
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery.bootgrid-1.3.1/jquery.bootgrid.js"></script>		
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/dialog/dialog.js?t=<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery.webui-popover/jquery.webui-popover.js"></script>		
		<script type="text/javascript" src="<?php echo base_url();?>src/js/tools.js"></script>		
		<script type="text/javascript" src="<?php echo base_url();?>src/js/live-chat/live-chat.js?t=<?php echo time();?>"></script>	
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/simple_video_player/simple_video_player.js?t=<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/tree_grid/tree_grid.js?t=<?php echo time();?>"></script>		
		<script>
			$('body').delegate('iframe', 'load', function(){
				this.style.height = this.contentWindow.document.body.scrollHeight + 'px';
			}).ready(function(){
			    $('[data-toggle="tooltip"]').tooltip(); 
			});
		</script>
	</head>

	<body>
		<?php
		if(empty($user)){
		?>
		<div id="live-chat"></div>
		<script>$('#live-chat').live_chat({url: '<?php echo base_url();?>chat'});</script>
		<?php
		}
		?>
		<div id="main" class="container-fluid" style="margin:0;padding:0">
			<?php
			$this->load->view("header", $this->_ci_cached_vars);
			?>
			<div id="main-body">
				<?php
				$this->load->view("$view", $this->_ci_cached_vars);
				?>
			</div>
			<?php $this->load->view('footer');?>
		</div>
	</body>
</html>