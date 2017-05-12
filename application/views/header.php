<style>
.menu-icon{text-align:center;width:90px;padding:9px 0;float:left;border:1px solid #fff}	
.menu-icon:hover{border:1px solid #e5e5e5}
.menu-icon a{color:#000;text-decoration:none}
.menu-icon img{width:50px;height:50px}	
.menu-icon .text{margin-top:5px}
</style>
<header id="main-header">
	<div id="logo" class="pull-left clearfix"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>src/img/lfc.png"></a></div>
	<div id="main-header-menu" class="list-unstyled pull-right clearfix">
			<span class="glyphicon glyphicon-th" id="menu-icon" style="cursor:pointer;font-size:20px"></span>
			<div style="display:none">
					<div class="clearfix" style="width:300px;border-bottom:1px solid #e5e5e5;padding:15px">
					<?php
					if(!empty($user)){
					?>
						<div class="menu-icon"><a href="<?php echo base_url();?>account" title="Startup"><img src="<?php echo base_url();?>src/img/rocket-icon.svg"><div class="text">Startup</div></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>account/startup" title="Business"><img src="<?php echo base_url();?>src/img/give-money.svg"><div class="text">Business</div></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>account/documents" title="Education"><img src="<?php echo base_url();?>src/img/books-stack-of-three.svg"><div class="text">Education</div></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>account/live" title="Live"><img src="<?php echo base_url();?>src/img/television.svg"><div class="text">Live</div></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>account/profile" title="Profile"><img src="<?php echo base_url();?>src/img/man-user.svg?1"><div class="text">Profile</div></a></div>
					<?php
					}
					?>
						<div class="menu-icon"><a href="<?php echo base_url();?>" title="Home"><img src="<?php echo base_url();?>src/img/home.svg"><div class="text">Home</div></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>resource" title="Resource"><img src="<?php echo base_url();?>src/img/folded-newspaper.svg"><div class="text">Resource</div></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>events" title="Events"><img src="<?php echo base_url();?>src/img/drinking.svg"><div class="text">Events</div></a></div>
					</div>
					<div class="clearfix" style="width:300px;padding:15px">
						<div class="menu-icon"><a href="<?php echo base_url();?>contact" title="Contact us"><img src="<?php echo base_url();?>src/img/telephone.svg?1"><div class="text">Contact Us</div></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>about" title="About us"><img src="<?php echo base_url();?>src/img/about-us.svg"><div class="text">About Us</div></a></div>
						<?php
						if(empty($user)){
						?>
						<div class="menu-icon"><a href="<?php echo base_url();?>ac/sign_in" title="Sign in"><img src="<?php echo base_url();?>src/img/sign-in.svg"><div class="text">Sign in</div></a></div>
						<?php
						}
						else{
						?>
						<div class="menu-icon"><a href="<?php echo base_url();?>ac/sign_out" title="Sign out"><img src="<?php echo base_url();?>src/img/sign-out-option.svg"><div class="text">Sign out</div></a></div>
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
			});
		</script>
	</div>
<script>
function toggle_chat(){
	$('#live-chat').slideToggle();
}
</script>
</header>
