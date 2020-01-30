<style>
.main-head-menu{float:left;margin-left:20px;margin-top:32px}
.main-head-menu .dropdown{float:left;margin-left:25px}
.main-head-menu .dropdown-toggle{color:#fff;font-size:20px;cursor:pointer;font-family:drugs}
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
@media only screen and (max-width:10000px) {
.main-head-menu{display:none}	
}
</style>
<header id="main-header">
	<div id="logo" class="pull-left clearfix"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>src/img/lfc.png"></a></div>
	<!--div class="main-head-menu clearfix">
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
	</div-->
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
				<a class="menu-ico-url" href="<?php echo base_url().$sm['url'];?>"><div class="menu-icon clearfix"><img src="<?php echo base_url().'src/img/'.$sm['icon'];?>"><div class="text"><?php echo $sm['text'];?></div></div></a>
			<?php
					$is_first2 = false;
				}
			}
			$is_first1 = false;
		}
		?>
			</div>
		</div>
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
