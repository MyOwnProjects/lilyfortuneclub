<style>
.menu-icon{padding:5px 0;border:1px solid #fff;padding:5px 15px;min-width:200px}
.menu-icon:hover{background:#e5e5e5}
.menu-ico-url:first-child .menu-icon{margin-top:10px}
.menu-ico-url:last-child .menu-icon{margin-bottom:10px}
.menu-icon a{color:#000;text-decoration:none}
.menu-icon img{float:left;width:20px;height:20px}	
.menu-icon .text{float:left;margin-left:10px;line-height:20px}
.webui-popover{position:fixed;top:61px !important;left:auto !important;right:0 !important}
.webui-arrow{left:auto !important;right: 22px;}
</style>
<header id="main-header">
	<div id="logo" class="pull-left clearfix"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>src/img/lfc.png"></a></div>
	<div id="main-header-menu" class="list-unstyled pull-right clearfix">
			<span class="glyphicon glyphicon-menu-hamburger" id="menu-icon" style="cursor:pointer;font-size:25px"></span>
			<div style="display:none">
					<?php
					if($user && $user['grade'] == 'SMD'){
					?>
					<div class="clearfix" style="border-bottom:1px solid #e5e5e5;">
						<a class="menu-ico-url" href="<?php echo base_url();?>smd" title="SMD"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/hierarchical-structure.svg"><div class="text">SMD Account</div></div></a>
					</div>
					<?php }?>
					<div class="clearfix" style="border-bottom:1px solid #e5e5e5;">
						<a class="menu-ico-url" href="<?php echo base_url();?>" title="Home"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/home.svg"><div class="text">Home</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>resource" title="Resource"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/folded-newspaper.svg"><div class="text">Resource</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>seminar" title="Seminar"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/instructor-lecture-with-sceen-projection-tool.svg"><div class="text">Class Schedule</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>documents" title="Education"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/books-stack-of-three.svg"><div class="text">Education</div></div></a>
					<?php
					if(!empty($user)){
					?>
						<a class="menu-ico-url" href="<?php echo base_url();?>account" title="Startup"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/rocket-icon.svg"><div class="text">Startup</div></div></a>
						<?php if($user['preference'] == 'B' || $user['preference'] == 'BE'){?>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/business" title="Business"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/give-money.svg"><div class="text">Business</div></div></a>
						<?php }?>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/license" title="License"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/certificate.svg"><div class="text">License</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/code_of_honor" title="Code of Honor"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/promotion.svg"><div class="text">Code of Honor</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/finance_status" title="Finance Status"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/learning.svg"><div class="text">Your Fiance Status</div></div></a>
						<!--div class="menu-icon"><a href="<?php echo base_url();?>account/live" title="Live"><img src="<?php echo base_url();?>src/img/television.svg"><div class="text">Live</div></a></div-->
						<a class="menu-ico-url" href="<?php echo base_url();?>account/terminology" title="Terminologies"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/terminology.svg"><div class="text">Terminologies</div></div></a>
						<!--a class="menu-ico-url" href="<?php echo base_url();?>account/tools" title="Tools"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/work-tools-cross.svg?1"><div class="text">Tools</div></div></a-->
						<a class="menu-ico-url" href="<?php echo base_url();?>account/how_to" title="How to"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/finger-of-a-hand-pointing-to-right-direction.svg?"><div class="text">How to</div></div></a>
						<a class="menu-ico-url" href="<?php echo base_url();?>account/profile" title="Profile"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/man-user.svg?1"><div class="text">Profile</div></div></a>
					<?php
					}
					?>
					</div>
					<div class="clearfix">
						<a class="menu-ico-url" href="<?php echo base_url();?>contact" title="Contact us"><div class="menu-icon clearfix"><img src="<?php echo base_url();?>src/img/telephone.svg?1"><div class="text">Contact Us</div></div></a>
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
			</div>
		<script>
			$('#menu-icon').webuiPopover({
				html: true,
				content:$('#menu-icon').next().html(),
				placement:'auto-bottom',
				dismissible:true,
				padding:false,
				//trigger: 'hover'
			});
		</script>
	</div>
	<?php
	if($user){
	?>
	<div class="main-header-text pull-right">
		<span class="glyphicon glyphicon-user"></span>
		&nbsp;
		<?php
		echo $user['first_name'].' '.$user['last_name'].' ('.$user['membership_code'].')';
		?>
	</div>
	<?php
	}
	?>
<script>
function toggle_chat(){
	$('#live-chat').slideToggle();
}
</script>
</header>
