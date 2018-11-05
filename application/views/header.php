<style>
.main-head-menu{float:left;margin-left:20px;margin-top:33px}
.main-head-menu .dropdown{float:left;margin-left:25px}
.main-head-menu .dropdown-toggle{color:#fff;font-size:18px;cursor:pointer}
.main-head-menu .dropdown a{text-decoration:none;}
.menu-icon{padding:5px 0;border:1px solid #fff;padding:5px 15px;min-width:200px}
.menu-icon:hover{background:#e5e5e5}
.menu-ico-url:first-child .menu-icon{margin-top:10px}
.menu-ico-url:last-child .menu-icon{margin-bottom:10px}
.menu-icon a{color:#000;text-decoration:none}
.menu-icon img{float:left;width:20px;height:20px}	
.menu-icon .text{float:left;margin-left:10px;line-height:20px}
.webui-popover1{position:fixed;top:61px !important;left:auto !important;right:0 !important;}
.webui-arrow1{left:auto !important;right: 22px;}
.webui-popover-inner1{max-height:300px;overflow-y:auto}
@media only screen and (max-width:768px) {
.main-head-menu{display:none}	
}
</style>
<header id="main-header">
	<div id="logo" class="pull-left clearfix"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>src/img/lfc.png"></a></div>
	<div class="main-head-menu clearfix">
		<?php
		foreach($navigation as $nav){
			if(array_key_exists('member_access', $nav) && $nav['member_access'] && empty($user)){
				continue;
			}
			if(array_key_exists('member_access', $nav) && !$nav['member_access'] && !empty($user)){
				continue;
			}
			$has_sub_menu = array_key_exists('sub_menu', $nav) && !empty($nav['sub_menu']);
		?>
		<div class="dropdown">
			<a class="dropdown-toggle" <?php echo $has_sub_menu ? 'data-toggle="dropdown"' : '';?>>
				<?php echo $nav['text'];?>
				<?php echo $has_sub_menu ? '<span class="caret"></span>' : '';?>
			</a>
			<?php
			if($has_sub_menu){
			?>
			<ul class="dropdown-menu">
			<?php
				foreach($nav['sub_menu'] as $sm){
					if(array_key_exists('member_access', $sm) && $sm['member_access'] && empty($user)){
						continue;
					}
					if(array_key_exists('member_access', $sm) && !$sm['member_access'] && !empty($user)){
						continue;
					}
					if((empty($user) || $user['grade'] != 'SMD') && $sm['url'] == 'smd'){
						continue;
					}
				?>
				  <li><a href="<?php echo base_url().$sm['url'];?>"><img style="height:20px;margin-top:-2px" src="<?php echo base_url().'src/img/'.$sm['icon'];?>">&nbsp;&nbsp;<?php echo $sm['text'];?></a></li>
				<?php
				}
			}
			?>
		</div>
		<?php
		}
		?>
	</div>
	<div id="main-header-menu" class="list-unstyled pull-right clearfix">
		<span class="glyphicon glyphicon-menu-hamburger" id="menu-icon" style="cursor:pointer;font-size:25px"></span>
		<div style="display:none">
		<?php
		$is_first1 = true;
		foreach($navigation as $nav){
			if(array_key_exists('member_access', $nav) && $nav['member_access'] && empty($user)){
				continue;
			}
			if(array_key_exists('member_access', $nav) && !$nav['member_access'] && !empty($user)){
				continue;
			}
			$has_sub_menu = array_key_exists('sub_menu', $nav) && !empty($nav['sub_menu']);
			if($has_sub_menu){
				$is_first2 = true;
				foreach($nav['sub_menu'] as $sm){
					if(array_key_exists('member_access', $sm) && $sm['member_access'] && empty($user)){
						continue;
					}
					if(array_key_exists('member_access', $sm) && !$sm['member_access'] && !empty($user)){
						continue;
					}
					if((empty($user) || $user['grade'] != 'SMD') && $sm['url'] == 'smd'){
						continue;
					}
					if($is_first2){
						if(!$is_first1){
			?>
			</div>
			<?php
						}
			?>
			<div class="clearfix" <?php echo !$is_first1 && $is_first2  ? 'style="border-top:1px solid #e5e5e5;"' : '';?>>
			<?php
					}
			?>
				<a class="menu-ico-url" href="<?php echo base_url();?>account/license" title="License"><div class="menu-icon clearfix"><img src="<?php echo base_url().'src/img/'.$sm['icon'];?>"><div class="text"><?php echo $sm['text'];?></div></div></a>
			<?php
					$is_first2 = false;
				}
			}
			$is_first1 = false;
		}
		?>
			</div>
		</div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		<!--div style="display:none">
					<?php
					if($user && $user['grade'] == 'SMD'){
					?>
					<div class="clearfix" style="border-bottom:1px solid #e5e5e5;">
						<a class="menu-ico-url" href="<?php echo base_url();?>smd" title="SMD"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/hierarchical-structure.svg"><div class="text">SMD Account</div></div></a>
					</div>
					<?php }?>
					<div class="clearfix" style="border-bottom:1px solid #e5e5e5;">
						<a class="menu-ico-url" href="<?php echo base_url();?>" title="Home"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/home.svg"><div class="text">Home</div></div></a>
					<?php
					if(!empty($user)){
					?>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/profile" title="Personal Information"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/man-user.svg?1"><div class="text">Personal Information</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/daily_report" title="Daily Report"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/diagram.svg?1"><div class="text">Daily Report</div></div></a>
					<?php
						if($user['membership_code'] != 'GUEST'){
					?>
						<?php if($user['preference'] == 'B' || $user['preference'] == 'BE'){?>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/faq" title="How to"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/question-mark-on-a-circular-black-background.svg"><div class="text">FAQ</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/how_to" title="How to"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/information-button.svg"><div class="text">How to</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/team" title="My team"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/team.svg"><div class="text">My Team</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/sales" title="My sales"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/sale.svg"><div class="text">My Sales</div></div></a>
						<?php }?>
					<?php
						}
					?>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/license" title="License"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/certificate.svg"><div class="text">License</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/startup" title="Who We Are"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/rocket-icon.svg"><div class="text">Who We Are</div></div></a>
					<?php
						if($user['membership_code'] != 'GUEST'){
					?>
						<a class="menu-ico-url" href="<?php echo base_url();?>seminar" title="Seminar"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/instructor-lecture-with-sceen-projection-tool.svg"><div class="text">Class Schedule</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/code_of_honor" title="Code of Honor"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/promotion.svg"><div class="text">Code of Honor</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/documents" title="Education"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/books-stack-of-three.svg"><div class="text">Education</div></div></a>
					<?php
						}
					?>
					<?php
					}
					else{
					?>
						<a class="menu-ico-url" href="<?php echo base_url();?>documents" title="Education"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/books-stack-of-three.svg"><div class="text">Education</div></div></a>
					<?php
					}
					?>
						<a class="menu-ico-url" href="<?php echo base_url();?>resource" title="Resource"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/folded-newspaper.svg"><div class="text">Resource</div></div></a>
					</div>
					<div class="clearfix">
						<?php
						if(!empty($user)){
						?>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/contact" title="Contact us"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/telephone.svg?1"><div class="text">Contact Us</div></div></a>
						<?php
						}
						else{
						?>
						<a class="menu-ico-url" href="<?php echo base_url();?>contact" title="Contact us"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/telephone.svg?1"><div class="text">Contact Us</div></div></a>
						<?php
						}
						?>
						<a class="menu-ico-url" href="<?php echo base_url();?>about" title="About us"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/about-us.svg"><div class="text">About Us</div></div></a>
						<?php
						if(empty($user)){
						?>
						<a class="menu-ico-url" href="<?php echo base_url();?>ac/sign_in" title="Sign in"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/sign-in.svg"><div class="text">Sign in</div></div></a>
						<?php
						}
						else{
						?>
						<a class="menu-ico-url" href="<?php echo base_url();?>ac/sign_out" title="Sign out"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/sign-out-option.svg"><div class="text">Sign out</div></div></a>
						<?php
						}
						?>
					</div>
			</div-->
	</div>
	<?php
	if($user){
	?>
	<div class="main-header-text pull-right" data-toggle="tooltip" data-placement="top" title="<?php echo $user['membership_code'];?>">
		<span id="profile-icon"><img src="<?php echo base_url();?>src/img/user.svg"></span>
		<?php
		//echo $user['first_name'].' '.$user['last_name'];
		?>
	</div>
	<?php
	}
	?>
	
	<div class="social-media-icon">
		<a href="https://www.linkedin.com/company/lily-fortune-club/" target="_blank"><img src="<?php echo base_url();?>src/img/linkedin-logo.svg"></a>
		&nbsp;
		<img src="<?php echo base_url();?>src/img/twitter-logo-silhouette.svg">
		&nbsp;
		<img src="<?php echo base_url();?>src/img/facebook-letter-logo.svg">
	</div>
	
<script>
function toggle_chat(){
	$('#live-chat').slideToggle();
}
	$('#menu-icon').webuiPopover({
	html: true,
				content:$('#menu-icon').next().html(),
				placement:'auto-bottom',
				dismissible:true,
				padding:false,
			});
			
	$('#profile-icon').webuiPopover({
		html: true,
		content:'<div style="padding:10px 20px;max-width:500px"><div style="white-space:nowrap"><?php echo $user['first_name'].' '.$user['last_name'].'<br/>'.$user['membership_code'];?></div></div>',
		placement:'auto-bottom',
		dismissible:true,
		padding:false,
	});
			
</script>
</header>
