<header id="main-header">
	<div id="logo" class="pull-left clearfix"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>src/img/lfc.png"></a></div>
	<ul id="main-header-menu" class="pull-right clearfix">
		<li class="main-header-menu-item pull-left">
		<?php
		if(empty($user)){
		?>
		<a href="<?php echo base_url();?>ac/sign_in" >Sign in</a>
		<?php
		}
		else{
		?>
		<li class="main-header-menu-item pull-left dropdown"><a class="dropdonw-toggle" data-toggle="dropdown"  href="#" >Account&nbsp;<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="<?php echo base_url();?>account">Overview</a></li>
				<li><a href="<?php echo base_url();?>account/documents" >Documents</a></li>
				<li><a href="<?php echo base_url();?>account/live" >Live</a></li>
				<li><a href="<?php echo base_url();?>account/profile">Profile</a></li>
				<li><a href="<?php echo base_url();?>account/password">Password</a></li>
				<li class="divider"></li>
				<li><a href="<?php echo base_url();?>ac/sign_out">Sign out</a></li>
			</ul>
		</li>
		<?php
		}
		?>
		</li>
		<li class="main-header-menu-item pull-left"><a href="<?php echo base_url();?>resource" >Resource</a></li>
		<li class="main-header-menu-item pull-left"><a href="<?php echo base_url();?>schedule" >Schedule</a></li>
		<li class="main-header-menu-item pull-left dropdown"><a class="dropdonw-toggle" data-toggle="dropdown"  href="#" >DIY&nbsp;<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="<?php echo base_url();?>finance_status">My Finance Status</a></li>
				<li><a href="#">Self Education</a></li>
				<li><a href="#">Business Partners</a></li>
				<li><a href="#" >Advisor</a></li>
			</ul>
		</li>
		<?php 
		if(empty($user)){
		?>
		<li class="main-header-menu-item pull-left"><a href="#" onclick="toggle_chat()">Live Chat&nbsp;<span class="caret"></span></a></li>
		<?php
		}
		?>
		<li class="main-header-menu-item pull-left"><a href="#" >About Us</a></li>
	</ul>
	<div id="main-header-menu-dropdown" class="dropdown pull-right">
		<div class="dropdown-toggle" data-toggle="dropdown" style="color:#fff"><span class="glyphicon glyphicon-menu-hamburger"></span></div>
		<ul class="dropdown-menu">
			<li><a href="<?php echo base_url();?>resource" >Resource</a></li>
			<li class="main-header-menu-item pull-left"><a href="<?php echo base_url();?>schedule" >Schedule</a></li>
			<li><a href="#" >Advisor</a></li>
			<li><a href="<?php echo base_url();?>finance_status">My Finance Status</a></li>
			<li><a href="#">Self Education</a></li>
			<li><a href="#">Business Partners</a></li>
			<li><a href="#" >About Us</a></li>
			<li class="divider"></li>
			<li>
			<?php
			if(!empty($user)){
			?>
			<a href="<?php echo base_url();?>ac/sign_out" >Sign out</a>
			<?php
			}
			else{
			?>
			<a href="<?php echo base_url();?>ac/sign_in" >Sign in</a>
			<?php
			}
			?>
			</li>		  
		</ul>
	</div>
<script>
function toggle_chat(){
	$('#live-chat').slideToggle();
}
</script>
</header>
