<!DOCTYPE html>
<html>
	<head>
		<script>var base_url = '<?php echo base_url();?>'; </script>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/jquery.mobile-1.4.5/theme-classic.css">
		<link rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/w3.css?<?php echo time();?>">
		<link rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/font-awesome-4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>src/css/mobile/main.css?<?php echo time();?>">
		<script src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
		<script src="<?php echo base_url();?>src/3rd_party/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>
		<script src="<?php echo base_url();?>src/js/tools.js?<?php echo time();?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/pdfjs/build/pdf.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/simple_video_player/simple_video_player.js?t=<?php echo time();?>"></script>
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
	var o_width, o_height;
	$(window).resize(function(){
		var frame = $('.youtube-link');
		frame.innerHeight(frame.innerWidth() *  o_height / o_width) ;
	});
	$(document).on("pagecontainerload",function(){
		var frame = $('.youtube-link');
		o_width = parseInt(frame.attr('width'));
		o_height = parseInt(frame.attr('height'));
		frame.removeAttr('width').removeAttr('height').css('width', '100%').css('max-width', o_width + 'px');
		frame.innerHeight(frame.innerWidth() *  o_height / o_width) 
			.attr('allowfullscreen', 'allowfullscreen').attr('mozallowfullscreen', 'mozallowfullscreen').attr('msallowfullscreen', 'msallowfullscreen')
			.attr('oallowfullscreen', 'oallowfullscreen').attr('webkitallowfullscreen', 'webkitallowfullscreen');
	});
	$(document).on("pageshow","#resource-item",function(){ // When entering pagetwo
		var frame = $('.youtube-link');
		o_width = parseInt(frame.attr('width'));
		o_height = parseInt(frame.attr('height'));
		frame.removeAttr('width').removeAttr('height').css('width', '100%').css('max-width', o_width + 'px');
		frame.innerHeight(frame.innerWidth() *  o_height / o_width) 
			.attr('allowfullscreen', 'allowfullscreen').attr('mozallowfullscreen', 'mozallowfullscreen').attr('msallowfullscreen', 'msallowfullscreen')
			.attr('oallowfullscreen', 'oallowfullscreen').attr('webkitallowfullscreen', 'webkitallowfullscreen');
	});
	</script>
	<body>
		<div data-role="popup" id="popup" data-role="page" class="ui-content ui-body-d ui-body-inherit"></div>
		<script>$( "#popup" ).popup()</script>
		<?php
		$this->load->view("$view", $this->_ci_cached_vars);
		//$this->load->view("mobile/footer", $this->_ci_cached_vars);
		?>
		<div data-role="page" id="main-menu" data-theme="d">
			<a data-rel="back" class="nondec menu-list" data-transition="slide" data-direction="reverse" style="text-align:right">×</a>
			<a href="<?php echo base_url();?>" data-ajax="false" class="nondec menu-list"><img src="<?php echo base_url();?>src/img/home.svg">Home</a>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>resource"><img src="<?php echo base_url();?>src/img/folded-newspaper.svg">Resource</a>
			<a  class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>seminar"><img src="<?php echo base_url();?>src/img/instructor-lecture-with-sceen-projection-tool.svg">Seminar</a>
			<?php
			if(!empty($user)){
			?>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>account/startup"><img src="<?php echo base_url();?>src/img/rocket-icon.svg">Startup</a>
			<?php if($user['preference'] == 'B' || $user['preference'] == 'BE'){?>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>account/business"><img src="<?php echo base_url();?>src/img/give-money.svg">Business</a>
			<?php }?>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>account/license"><img src="<?php echo base_url();?>src/img/certificate.svg">License</a>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>account/documents"><img src="<?php echo base_url();?>src/img/books-stack-of-three.svg">Education</a>
			<!--a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>account/live"><img src="<?php echo base_url();?>src/img/television.svg">Live</a-->
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>account/profile"><img src="<?php echo base_url();?>src/img/man-user.svg?1">Profile</a>
			<?php }?>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>contact"><img src="<?php echo base_url();?>src/img/telephone.svg?1">Contact Us</a>
			<?php
			if(!empty($user)){
			?>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>ac/sign_out"><img src="<?php echo base_url();?>src/img/sign-out-option.svg">Sign out</a>
			<?php
			}
			else{
			?>
			<a class="nondec menu-list" data-ajax="false" href="<?php echo base_url();?>ac/sign_in"><img src="<?php echo base_url();?>src/img/sign-in.svg">Sign in</a>
			<?php
			}
			?>	
  		</div>
	</body>
</html>