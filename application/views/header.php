<style>
.menu-icon{text-align:center;width:50px;padding:9px 0;float:left;border:1px solid #fff}	
.menu-icon:hover{border:1px solid #e5e5e5}	
.menu-icon img{width:30px;height:30px}	
</style>
<header id="main-header">
	<div id="logo" class="pull-left clearfix"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>src/img/lfc.png"></a></div>
	<div id="main-header-menu" class="list-unstyled pull-right clearfix">
			<span class="glyphicon glyphicon-th" id="menu-icon" style="cursor:pointer;font-size:20px"></span>
			<div style="display:none">
					<div class="clearfix" style="width:180px;border-bottom:1px solid #e5e5e5;padding:15px">
					<?php
					if(!empty($user)){
					?>
						<div class="menu-icon"><a href="<?php echo base_url();?>account" title="Startup"><image src="<?php echo base_url();?>src/img/rocket-icon.svg"></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>account/startup" title="Bisuness"><image src="<?php echo base_url();?>src/img/give-money.svg"></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>account/documents" title="Education"><image src="<?php echo base_url();?>src/img/books-stack-of-three.svg"></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>account/live" title="Live"><image src="<?php echo base_url();?>src/img/television.svg"></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>account/profile" title="Profile"><image src="<?php echo base_url();?>src/img/man-user.svg?1"></a></div>
					<?php
					}
					?>
						<div class="menu-icon"><a href="<?php echo base_url();?>" title="Home"><image src="<?php echo base_url();?>src/img/home.svg"></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>resource" title="Resource"><image src="<?php echo base_url();?>src/img/folded-newspaper.svg"></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>events" title="Events"><image src="<?php echo base_url();?>src/img/drinking.svg"></a></div>
					</div>
					<div class="clearfix" style="width:180px;padding:15px">
						<div class="menu-icon"><a href="<?php echo base_url();?>contact" title="Contact us"><image src="<?php echo base_url();?>src/img/telephone.svg?1"></a></div>
						<div class="menu-icon"><a href="<?php echo base_url();?>about" title="About us"><image src="<?php echo base_url();?>src/img/about-us.svg"></a></div>
						<?php
						if(empty($user)){
						?>
						<div class="menu-icon"><a href="<?php echo base_url();?>ac/sign_in" title="Sign in"><image src="<?php echo base_url();?>src/img/sign-in.svg"></a></div>
						<?php
						}
						else{
						?>
						<div class="menu-icon"><a href="<?php echo base_url();?>ac/sign_out" title="Sign out"><image src="<?php echo base_url();?>src/img/sign-out-option.svg"></a></div>
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
