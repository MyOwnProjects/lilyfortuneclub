<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/jquery.mobile-1.4.5/theme-classic1.css">
		<link rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/w3.css?<?php echo time();?>">
		<link rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/font-awesome-4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>src/css/mobile/main.css?<?php echo time();?>">
		<script src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
		<script src="<?php echo base_url();?>src/3rd_party/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>
		<script src="<?php echo base_url();?>src/js/tools.js?<?php echo time();?>"></script>
	</head>		
	<script>
	
	$(document).on("swiperight",function(){
		var prev = $.mobile.activePage.find('.nav-prev');
		if(prev.length > 0 && !prev.hasClass('ui-disabled')){
			prev.click();
			//$.mobile.changePage(prev.attr('href'), { transition: "slide", reverse: true } );
		}
	}).on("swipeleft",function(){
		var next = $.mobile.activePage.find('.nav-next');
		if(next.length > 0 && !next.hasClass('ui-disabled')){
			next.click();
			//$.mobile.changePage(next.attr('href'), { transition: "slide"} );
		}
	});
	
	</script>
	<body>
		<div data-role="popup" id="popup" class="ui-content ui-body-d ui-body-inherit"></div>
		<script>$( "#popup" ).popup()</script>
		<?php
		$this->load->view("$view", $this->_ci_cached_vars);
		//$this->load->view("mobile/footer", $this->_ci_cached_vars);
		?>
		<div data-role="page" id="main-menu" data-theme="d">
			<a href="javascript:void(0)" data-rel="back" class="nondec" style="float:right;font-size:26px;margin-right:10px" data-transition="slide" data-direction="reverse">×</a>
			<a href="<?php echo base_url();?>" data-ajax="false" class="nondec menu-list">Home</a>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>resource">Resource</a>
			<a  class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>events">Events</a>
			<?php
			if(!empty($user)){
			?>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>account/startup">Startup</a>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>account/business">Business</a>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>account/document">Education</a>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>account/live">Live</a>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>account/profile">Profile</a>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>ac/sign_out">Sign out</a>
			<?php
			}
			else{
			?>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>ac/sign_in">Sign in</a>
			<?php
			}
			?>	
  		</div>
	</body>
</html>